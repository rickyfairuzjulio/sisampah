<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\TrashCategory;
use App\Models\ScanLog;
use Database\Seeders\RoleAndPermissionSeeder;

class ScanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->seed(RoleAndPermissionSeeder::class);
        
        $this->user = User::factory()->create();
        $this->user->assignRole('nasabah');
        
        Storage::fake('public');
    }

    public function test_reject_vision_request_without_photo()
    {
        $response = $this->actingAs($this->user)->postJson(route('chat.vision'), []);
        
        $response->assertStatus(422)
                 ->assertJsonValidationErrors('image');
    }

    public function test_vision_scan_returns_valid_response()
    {
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => json_encode([
                                    'image_info' => [
                                        'kualitas_gambar' => 'Baik',
                                        'pencahayaan' => 'Cukup',
                                        'resolusi' => 'Tinggi',
                                        'jumlah_objek' => 1
                                    ],
                                    'is_valid' => true,
                                    'is_recognized' => true,
                                    'unrecognized_message' => null,
                                    'human_detected' => ['detected' => false],
                                    'objects_detected_list' => [
                                        ['nama' => 'Botol Plastik PET', 'kategori' => 'Plastik', 'confidence' => 95.0, 'is_trash' => true]
                                    ],
                                    'objects' => [
                                        [
                                            'nama_objek' => 'Botol Plastik PET',
                                            'material' => 'PET 1',
                                            'kategori' => 'anorganik',
                                            'estimasi_berat_kg' => 0.2,
                                            'harga_per_kg' => 3500,
                                            'estimasi_nilai_total' => 700,
                                            'layak_dijual' => true,
                                            'confidence' => 95.0,
                                            'kualifikasi' => 'Bersih & Kering'
                                        ]
                                    ],
                                    'summary' => [
                                        'jumlah_sampah' => 1,
                                        'total_estimasi_nilai' => 700
                                    ],
                                    'rekomendasi_tindakan' => 'Kumpulkan dan serahkan ke Bank Sampah.',
                                    'edukasi_singkat' => 'Botol PET dapat didaur ulang menjadi serat kain.'
                                ])]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $file = UploadedFile::fake()->image('botol.jpg');

        $response = $this->actingAs($this->user)->postJson(route('chat.vision'), [
            'image' => $file,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                 ]);
    }
}
