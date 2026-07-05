<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
            'trash_category_id' => 'required|exists:trash_categories,id',
            'perkiraan_berat' => 'required|numeric|min:5',
            'koordinat_lat' => 'required|numeric',
            'koordinat_lng' => 'required|numeric',
            'catatan' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'perkiraan_berat.min' => 'Akumulasi perkiraan berat sampah harus minimal 5 Kg.',
            'trash_category_id.required' => 'Kategori sampah harus dipilih.',
            'koordinat_lat.required' => 'Koordinat lokasi harus dideteksi.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $weight = (float) $this->input('perkiraan_berat', 0);

            if ($weight < 5) {
                $validator->errors()->add('perkiraan_berat', 'Perkiraan berat sampah harus minimal 5 Kg.');
            }
        });
    }
}
