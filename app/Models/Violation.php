<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_sampah_id',
        'user_id',
        'reporter_id',
        'user_name',
        'user_role',
        'phone',
        'tipe',
        'tipe_label',
        'deskripsi',
        'sanksi',
        'poin_penalti',
        'bukti_foto',
        'status',
        'catatan_penyelesaian',
        'resolved_at',
    ];

    protected $casts = [
        'poin_penalti' => 'integer',
        'resolved_at' => 'datetime',
    ];

    public function bankSampah()
    {
        return $this->belongsTo(BankSampah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
