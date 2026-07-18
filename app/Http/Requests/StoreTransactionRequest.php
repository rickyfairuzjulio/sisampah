<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('petugas');
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.trash_category_id' => 'required|exists:trash_categories,id',
            'items.*.berat_kg' => 'required|numeric|min:0.1',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Daftar sampah tidak boleh kosong.',
            'items.min' => 'Daftar sampah tidak boleh kosong.',
            'items.*.berat_kg.min' => 'Berat sampah harus minimal 0.1 Kg.',
            'items.*.trash_category_id.required' => 'Kategori sampah harus dipilih.',
        ];
    }
}
