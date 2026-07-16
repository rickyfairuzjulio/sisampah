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
            'metode' => 'required|in:tunai,bca,bri,bsi,dana,gopay',
            'rekening_tujuan' => 'required_unless:metode,tunai|nullable|string|max:50',
            'nama_penerima' => 'required_unless:metode,tunai|nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nominal.min' => 'Nominal penarikan minimal Rp 10.000.',
            'metode.required' => 'Metode penarikan harus dipilih.',
            'metode.in' => 'Metode penarikan tidak valid.',
            'rekening_tujuan.required_unless' => 'Nomor rekening/e-wallet wajib diisi untuk transfer.',
            'nama_penerima.required_unless' => 'Nama penerima wajib diisi untuk transfer.',
        ];
    }
}
