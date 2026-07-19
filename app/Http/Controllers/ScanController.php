<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\TrashCategory;
use App\Models\ScanLog;

class ScanController extends Controller
{
    private function getScanPrompt()
    {
        return 'Kamu adalah sistem identifikasi jenis sampah untuk bank sampah di Indonesia.
Analisis gambar sampah ini dan balas HANYA dalam format JSON berikut, tanpa teks atau markdown lain:
{
"nama": "string, nama spesifik sampah yang paling mendekati (contoh: Botol PET, Kardus Bekas, Kertas HVS)",
"kategori": "organik | anorganik | b3 | residu",
"jenis": "deskripsi jenis material (contoh: Botol PET, Kantong, Kemasan)",
"confidence": angka 0.0 - 1.0
}
Fokus HANYA mengidentifikasi apa jenis sampahnya secara fisik, JANGAN menilai kualitas, harga, atau manfaat — itu bukan tugasmu.';
    }

    public function scan(Request $request)
    {
        $request->validate(['foto' => 'required|image|max:5120']);

        $path = $request->file('foto')->store('scans', 'public');
        $base64 = base64_encode(file_get_contents($request->file('foto')->getRealPath()));

        $response = Http::withHeaders([
            'x-goog-api-key' => config('services.gemini.key'),
            'Content-Type' => 'application/json',
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
            'contents' => [[
                'parts' => [
                    ['text' => $this->getScanPrompt()],
                    ['inline_data' => ['mime_type' => 'image/jpeg', 'data' => $base64]]
                ]
            ]]
        ]);

        $aiText = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
        $aiJson = json_decode(str_replace(['```json', '```'], '', $aiText ?? ''), true);

        if (!$aiJson) {
            return response()->json(['error' => 'Gagal menganalisis foto, coba lagi.'], 422);
        }

        // Matching ke trash_categories yang sudah ada, exclude yang di-archive
        $matched = TrashCategory::where('is_archived', false)
            ->where(function ($q) use ($aiJson) {
                $q->where('nama', 'like', '%' . $aiJson['nama'] . '%')
                  ->orWhere('jenis', 'like', '%' . $aiJson['jenis'] . '%');
            })
            ->where('kategori', $aiJson['kategori'])
            ->first();

        $scanLog = ScanLog::create([
            'user_id' => auth()->id(),
            'foto_path' => $path,
            'trash_category_id' => $matched?->id,
            'ai_detected_nama' => $aiJson['nama'],
            'ai_detected_kategori' => $aiJson['kategori'],
            'confidence' => $aiJson['confidence'] ?? 0,
            'ai_raw_response' => $aiJson,
            'status' => $matched ? 'matched' : 'unmatched',
        ]);

        if (!$matched) {
            return response()->json([
                'matched' => false,
                'ai_detected_nama' => $aiJson['nama'] ?? 'Tidak diketahui',
                'message' => 'Laporkan gagal, dan suruh pilih manual',
            ]);
        }

        return response()->json([
            'matched' => true,
            'id' => $matched->id,
            'kode' => $matched->kode,
            'nama' => $matched->nama,
            'kategori' => $matched->kategori,
            'jenis' => $matched->jenis,
            'gambar' => $matched->gambar,
            'deskripsi' => $matched->deskripsi,
            'kualitas' => $matched->kualitas,
            'manfaat' => $matched->manfaat,
            'harga_per_kg' => $matched->harga_per_kg,
            'harga_per_gram' => $matched->harga_per_gram,
            'confidence' => $aiJson['confidence'] ?? 0,
        ]);
    }
}
