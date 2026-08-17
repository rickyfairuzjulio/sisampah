<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankSampahVerification extends Model
{
    protected $fillable = [
        'bank_sampah_id',
        'method',
        'scheduled_at',
        'completed_at',
        'result',
        'checklist',
        'notes',
        'evidence_path',
        'verified_by',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'checklist' => 'array',
    ];

    public function bankSampah(): BelongsTo
    {
        return $this->belongsTo(BankSampah::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
