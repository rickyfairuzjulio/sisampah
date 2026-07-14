<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWithdrawalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('nasabah');
    }

    public function rules(): array
    {
        return [
            'nominal' => 'required|numeric|min:10000',
            'metode' => 'required|in:tunai,transfer',
            'rekening_tujuan' => 'nullable|string|max:50',
            'nama_penerima' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nominal.min' => 'Nominal penarikan minimal Rp 10.000.',
            'metode.required' => 'Metode penarikan harus dipilih.',
        ];
    }
}
