<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePickupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('nasabah');
    }

    public function rules(): array
    {
        return [
            'bank_sampah_id' => 'nullable|exists:bank_sampahs,id',
            'items' => 'required|array|min:1',
            'items.*.trash_category_id' => 'required|exists:trash_categories,id',
            'items.*.perkiraan_berat' => 'required|numeric|min:0.1',
            'koordinat_lat' => 'required|numeric',
            'koordinat_lng' => 'required|numeric',
            'alamat_lengkap' => 'nullable|string',
            'catatan' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Daftar sampah tidak boleh kosong.',
            'items.min' => 'Daftar sampah tidak boleh kosong.',
            'items.*.trash_category_id.required' => 'Kategori sampah harus dipilih.',
            'items.*.perkiraan_berat.required' => 'Berat sampah harus diisi.',
            'items.*.perkiraan_berat.min' => 'Berat sampah minimal 0.1 Kg.',
            'koordinat_lat.required' => 'Koordinat lokasi harus dideteksi.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $items = $this->input('items', []);
            $totalWeight = 0;
            
            if (is_array($items)) {
                foreach ($items as $item) {
                    $totalWeight += (float) ($item['perkiraan_berat'] ?? 0);
                }
            }

            if ($totalWeight < 5) {
                $validator->errors()->add('items', 'Total perkiraan berat keseluruhan sampah harus minimal 5 Kg.');
            }
        });
    }
}
