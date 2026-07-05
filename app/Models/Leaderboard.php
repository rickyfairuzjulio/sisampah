<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'total_poin_lingkungan', 'total_berat_kg', 'jumlah_transaksi'])]
class Leaderboard extends Model
{
    protected function casts(): array
    {
        return [
            'total_berat_kg' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
