<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletLedger extends Model
{
    protected $fillable = [
        'user_id',
        'bank_sampah_id',
        'transaction_id',
        'withdrawal_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'reference',
        'notes',
    ];

    protected $casts = [
        'amount' => 'float',
        'balance_before' => 'float',
        'balance_after' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bankSampah(): BelongsTo
    {
        return $this->belongsTo(BankSampah::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function withdrawal(): BelongsTo
    {
        return $this->belongsTo(Withdrawal::class);
    }

    public function getTypeBadgeBgAttribute(): string
    {
        return match ($this->type) {
            'credit' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'debit' => 'bg-rose-100 text-rose-800 border-rose-300',
            'withdrawal_hold' => 'bg-amber-100 text-amber-800 border-amber-300',
            'withdrawal_reversal' => 'bg-blue-100 text-blue-800 border-blue-300',
            'adjustment' => 'bg-purple-100 text-purple-800 border-purple-300',
            'refund' => 'bg-cyan-100 text-cyan-800 border-cyan-300',
            default => 'bg-slate-100 text-slate-800 border-slate-300',
        };
    }
}
