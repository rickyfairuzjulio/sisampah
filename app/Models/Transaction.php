<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'petugas_id', 'trash_category_id', 'berat_kg', 'harga_per_kg', 'total_rp', 'tipe_setoran', 'status', 'foto_bukti', 'koordinat_lat', 'koordinat_lng', 'catatan', 'rating', 'ulasan'])]
class Transaction extends Model
{
    use HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected function casts(): array
    {
        return [
            'berat_kg' => 'decimal:2',
            'harga_per_kg' => 'decimal:2',
            'total_rp' => 'decimal:2',
            'koordinat_lat' => 'decimal:7',
            'koordinat_lng' => 'decimal:7',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function trashCategory(): BelongsTo
    {
        return $this->belongsTo(TrashCategory::class);
    }
}
