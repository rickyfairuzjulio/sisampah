<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['trash_category_id', 'harga_lama', 'harga_baru', 'persentase_perubahan', 'admin_id', 'alasan'])]
class PriceHistory extends Model
{
    protected function casts(): array
    {
        return [
            'harga_lama' => 'decimal:2',
            'harga_baru' => 'decimal:2',
            'persentase_perubahan' => 'decimal:2',
        ];
    }

    // ─── Relationships ───

    public function trashCategory(): BelongsTo
    {
        return $this->belongsTo(TrashCategory::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // ─── Accessors ───

    public function getChangeDirectionAttribute(): string
    {
        if ($this->harga_baru > $this->harga_lama) {
            return 'naik';
        }
        if ($this->harga_baru < $this->harga_lama) {
            return 'turun';
        }

        return 'stabil';
    }

    public function getChangeColorAttribute(): string
    {
        return match ($this->change_direction) {
            'naik' => 'text-green-600',
            'turun' => 'text-red-600',
            default => 'text-gray-500',
        };
    }

    public function getChangeBgAttribute(): string
    {
        return match ($this->change_direction) {
            'naik' => 'bg-green-100 text-green-800',
            'turun' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // ─── Scopes ───

    public function scopeByCategory($query, int $categoryId)
    {
        return $query->where('trash_category_id', $categoryId);
    }

    public function scopeByDateRange($query, ?string $startDate, ?string $endDate)
    {
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $query;
    }

    public function scopeByAdmin($query, int $adminId)
    {
        return $query->where('admin_id', $adminId);
    }
}
