<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
            'trash_category_id' => 'required|exists:trash_categories,id',
            'berat_kg' => 'required|numeric|min:0.5',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'berat_kg.min' => 'Berat sampah harus minimal 0.5 Kg.',
            'trash_category_id.required' => 'Kategori sampah harus dipilih.',
        ];
    }
}
