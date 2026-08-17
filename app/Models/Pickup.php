<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pickup extends Model
{
    protected $fillable = [
        'bank_sampah_id',
        'nasabah_id',
        'petugas_id',
        'address',
        'latitude',
        'longitude',
        'distance_km',
        'scheduled_at',
        'status',
        'failure_reason',
        'foto_bukti',
        'estimasi_berat',
        'berat_aktual',
        'catatan',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'distance_km' => 'float',
        'estimasi_berat' => 'float',
        'berat_aktual' => 'float',
        'scheduled_at' => 'datetime',
    ];

    public function bankSampah(): BelongsTo
    {
        return $this->belongsTo(BankSampah::class);
    }

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nasabah_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function getFotoBuktiUrlAttribute(): ?string
    {
        if (!$this->foto_bukti) return null;
        if (str_starts_with($this->foto_bukti, 'http')) return $this->foto_bukti;
        return asset('storage/' . $this->foto_bukti);
    }

    public function getStatusBadgeBgAttribute(): string
    {
        return match ($this->status) {
            'requested' => 'bg-amber-100 text-amber-800 border-amber-300',
            'validated', 'approved' => 'bg-blue-100 text-blue-800 border-blue-300',
            'assigned' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
            'on_the_way' => 'bg-cyan-100 text-cyan-800 border-cyan-300',
            'arrived', 'weighed' => 'bg-purple-100 text-purple-800 border-purple-300',
            'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'cancelled', 'failed' => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-slate-100 text-slate-800 border-slate-300',
        };
    }
}
