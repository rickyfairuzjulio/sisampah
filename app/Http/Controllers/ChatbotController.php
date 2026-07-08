<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array' // Array of previous chat history to keep context
        ]);

        $apiKey = env('GEMINI_API_KEY');
        
        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Konfigurasi GEMINI_API_KEY belum diatur oleh sistem.'
            ], 500);
        }

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        // Prepare contents array for Gemini
        $contents = [];

        // Build history context
        foreach ($history as $chat) {
            if (isset($chat['role']) && isset($chat['text'])) {
                $role = $chat['role'] === 'user' ? 'user' : 'model';
                $contents[] = [
                    'role' => $role,
                    'parts' => [['text' => $chat['text']]]
                ];
            }
        }

        // Add the new user message
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]]
        ];

        // System prompt to constrain the AI
        $systemPrompt = "Kamu adalah SiSampah Bot, asisten virtual resmi untuk platform Bank Sampah 'SiSampah'. Tugas UTAMAMU HANYA MENJAWAB pertanyaan seputar sampah, pengelolaan lingkungan, daur ulang, harga sampah, fitur aplikasi SiSampah (seperti setor mandiri, jemput sampah, penarikan saldo/dompet), dan edukasi lingkungan. JANGAN PERNAH menjawab pertanyaan di luar topik tersebut (misal: coding, sejarah umum, politik, matematika yang tidak terkait sampah, resep masakan, dll). Jika ada pertanyaan di luar topik, tolak dengan sopan dan arahkan kembali ke topik sampah/bank sampah. Gunakan bahasa Indonesia yang ramah, sopan, dan informatif. Ringkas dan jelas.";

        try {
            $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-lite-latest:generateContent?key={$apiKey}", [
                'system_instruction' => [
                    'parts' => ['text' => $systemPrompt]
                ],
                'contents' => $contents,
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 800,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    $reply = $data['candidates'][0]['content']['parts'][0]['text'];
                    return response()->json([
                        'success' => true,
                        'reply' => $reply
                    ]);
                }
            }

            Log::error('Gemini API Error: ' . $response->body());
            
            return response()->json([
                'success' => false,
                'message' => 'Maaf, terjadi kendala saat menghubungi AI. Silakan coba beberapa saat lagi.'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Chatbot Controller Exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.'
            ], 500);
        }
    }
}
