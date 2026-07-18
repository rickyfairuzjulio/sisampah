<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array', // Array of previous chat history to keep context
        ]);
        $apiKey = config('services.gemini.key');

        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Konfigurasi GEMINI_API_KEY belum diatur oleh sistem.',
            ], 500);
        }

        // Rate Limiting (Token Bucket: 10 req per 5 min)
        $rateLimitKey = 'chatbot:'.($request->user()?->id ?: $request->ip());

        if (RateLimiter::tooManyAttempts($rateLimitKey, 10)) {
            return response()->json([
                'success' => false,
                'message' => 'Sepertinya anda bertanya terlalu cepat. Mari beristirahat sejenak, silahkan coba lagi dalam 5 menit',
            ], 429);
        }

        // Record the hit (decay is 300 seconds = 5 minutes)
        RateLimiter::hit($rateLimitKey, 300);

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        // 1. Cek FAQ Database dulu untuk menghemat token Gemini
        // Jika ada pertanyaan yang mirip/relevan di DB, langsung gunakan jawabannya
        $faq = Faq::where('pertanyaan', 'LIKE', '%'.$userMessage.'%')->first();
        if ($faq) {
            return response()->json([
                'success' => true,
                'reply' => $faq->jawaban,
                'source' => 'faq', // Penanda untuk debugging (optional)
            ]);
        }

        // 2. Batasi History Chat (hanya ambil 4 pesan terakhir) agar tidak boros token
        if (count($history) > 4) {
            $history = array_slice($history, -4);
        }

        // Prepare contents array for Gemini
        $contents = [];

        // Build history context
        foreach ($history as $chat) {
            if (isset($chat['role']) && isset($chat['text'])) {
                $role = $chat['role'] === 'user' ? 'user' : 'model';
                $contents[] = [
                    'role' => $role,
                    'parts' => [['text' => $chat['text']]],
                ];
            }
        }

        // Add the new user message
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]],
        ];

        // System prompt to constrain the AI
        $systemPrompt = "Kamu adalah SiSampah Bot, asisten virtual resmi untuk platform Bank Sampah 'SiSampah'. Tugas UTAMAMU HANYA MENJAWAB pertanyaan seputar sampah, pengelolaan lingkungan, daur ulang, harga sampah, fitur aplikasi SiSampah (seperti setor mandiri, jemput sampah, penarikan saldo/dompet), dan edukasi lingkungan. JANGAN PERNAH menjawab pertanyaan di luar topik tersebut (misal: coding, sejarah umum, politik, matematika yang tidak terkait sampah, resep masakan, dll). Jika ada pertanyaan di luar topik, tolak dengan sopan dan arahkan kembali ke topik sampah/bank sampah. Gunakan bahasa Indonesia yang ramah, sopan, dan informatif. Ringkas dan jelas.";

        try {
            $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-lite-latest:generateContent?key={$apiKey}", [
                'system_instruction' => [
                    'parts' => ['text' => $systemPrompt],
                ],
                'contents' => $contents,
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 800,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    $reply = $data['candidates'][0]['content']['parts'][0]['text'];

                    return response()->json([
                        'success' => true,
                        'reply' => $reply,
                    ]);
                }
            }

            Log::error('Gemini API Error: '.$response->body());

            return response()->json([
                'success' => false,
                'message' => 'Maaf, terjadi kendala saat menghubungi AI. Silakan coba beberapa saat lagi.',
            ], 500);

        } catch (\Exception $e) {
            Log::error('Chatbot Controller Exception: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.',
            ], 500);
        }
    }
}
