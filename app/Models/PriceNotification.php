<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'trash_category_id', 'tipe', 'judul', 'pesan', 'is_read'])]
class PriceNotification extends Model
{
    use HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    // ─── Relationships ───

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trashCategory(): BelongsTo
    {
        return $this->belongsTo(TrashCategory::class);
    }

    // ─── Scopes ───

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForAdmin($query)
    {
        return $query->whereNull('user_id');
    }

    // ─── Accessors ───

    public function getTipeColorAttribute(): string
    {
        return match ($this->tipe) {
            'harga_naik' => 'bg-green-100 text-green-800',
            'harga_turun' => 'bg-red-100 text-red-800',
            'harga_drastis' => 'bg-orange-100 text-orange-800',
            'belum_update' => 'bg-yellow-100 text-yellow-800',
            'terlalu_rendah' => 'bg-blue-100 text-blue-800',
            'terlalu_tinggi' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
