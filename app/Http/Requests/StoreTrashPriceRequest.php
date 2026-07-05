<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrashPriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255', 'unique:trash_categories,nama'],
            'kategori' => ['required', 'in:organik,anorganik,b3'],
            'jenis' => ['nullable', 'string', 'max:255'],
            'harga_per_kg' => ['required', 'numeric', 'min:0'],
            'satuan' => ['required', 'in:kg,gram,unit'],
            'kualitas' => ['required', 'in:premium,standar,rendah'],
            'stok_dibutuhkan' => ['nullable', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'manfaat' => ['nullable', 'string'],
            'nilai_daur_ulang' => ['nullable', 'string', 'max:255'],
            'tips_penyimpanan' => ['nullable', 'string'],
            'tips_menjual' => ['nullable', 'string'],
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
