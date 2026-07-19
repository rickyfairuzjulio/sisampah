<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTrashPriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'nama' => ['required', 'string', 'max:255', Rule::unique('trash_categories', 'nama')->ignore($id)],
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
            'alasan' => ['nullable', 'string', 'max:255'],
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
