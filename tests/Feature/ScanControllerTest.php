<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\TrashCategory;
use App\Models\ScanLog;

class ScanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $petugas;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->petugas = User::factory()->create([
            'role' => 'petugas',
        ]);
        
        Storage::fake('public');
    }

    public function test_reject_request_without_photo()
    {
        $response = $this->actingAs($this->petugas)->postJson(route('petugas.scan.process'), []);
        
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['foto']);
    }

    public function test_matched_false_if_ai_detects_unknown_category()
    {
        // Mock Gemini response
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => '```json
{"nama": "Alien Artifact", "kategori": "residu", "jenis": "Unknown", "confidence": 0.9}
```']
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $file = UploadedFile::fake()->image('alien.jpg');

        $response = $this->actingAs($this->petugas)->postJson(route('petugas.scan.process'), [
            'foto' => $file,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'matched' => false,
                     'message' => 'Laporkan gagal, dan suruh pilih manual',
                 ]);

        $this->assertDatabaseHas('scan_logs', [
            'ai_detected_nama' => 'Alien Artifact',
            'status' => 'unmatched',
        ]);
    }

    public function test_matched_true_and_returns_data()
    {
        $category = TrashCategory::create([
            'kode' => 'PET01',
            'nama' => 'Botol Plastik PET',
            'kategori' => 'anorganik',
            'jenis' => 'Plastik',
            'harga_per_kg' => 3500,
            'harga_per_gram' => 3.5,
            'deskripsi' => 'Botol air mineral',
            'kualitas' => 'standar',
            'manfaat' => 'Bisa didaur ulang',
            'is_archived' => false,
        ]);

        // Mock Gemini response
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => '{"nama": "Botol Plastik PET", "kategori": "anorganik", "jenis": "Plastik", "confidence": 0.95}']
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $file = UploadedFile::fake()->image('botol.jpg');

        $response = $this->actingAs($this->petugas)->postJson(route('petugas.scan.process'), [
            'foto' => $file,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'matched' => true,
                     'kode' => 'PET01',
                     'nama' => 'Botol Plastik PET',
                 ]);

        $this->assertDatabaseHas('scan_logs', [
            'trash_category_id' => $category->id,
            'ai_detected_nama' => 'Botol Plastik PET',
            'status' => 'matched',
            'confidence' => 0.95,
        ]);
    }
}
