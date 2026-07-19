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

    public function getLevelAttribute(): int
    {
        $poin = (float) $this->total_poin_lingkungan;
        if ($poin >= 1000) {
            return 4;
        }
        if ($poin >= 500) {
            return 3;
        }
        if ($poin >= 100) {
            return 2;
        }

        return 1;
    }

    public function getBadgeNameAttribute(): string
    {
        return match ($this->level) {
            4 => 'Pahlawan Bumi',
            3 => 'Pejuang Lingkungan',
            2 => 'Penggerak Desa',
            default => 'Warga Peduli',
        };
    }

    public function getBadgeIconAttribute(): string
    {
        return match ($this->level) {
            4 => '🏆',
            3 => '🥇',
            2 => '🥈',
            default => '🥉',
        };
    }

    public function getBadgeColorAttribute(): string
    {
        return match ($this->level) {
            4 => 'from-blue-400 to-indigo-600',
            3 => 'from-amber-300 to-amber-500',
            2 => 'from-gray-300 to-gray-400',
            default => 'from-orange-700 to-orange-900',
        };
    }

    public function getNextLevelXpAttribute(): int
    {
        return match ($this->level) {
            1 => 100,
            2 => 500,
            3 => 1000,
            4 => 1000, // Max level
        };
    }

    public function getXpPercentageAttribute(): int
    {
        $poin = (float) $this->total_poin_lingkungan;

        if ($this->level === 4) {
            return 100;
        }

        $currentLevelBase = match ($this->level) {
            1 => 0,
            2 => 100,
            3 => 500,
        };

        $nextLevelGoal = $this->next_level_xp;

        $progress = $poin - $currentLevelBase;
        $required = $nextLevelGoal - $currentLevelBase;

        if ($required == 0) {
            return 100;
        }

        $percentage = ($progress / $required) * 100;

        return min(100, max(0, (int) round($percentage)));
    }
}
