<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'kategori',
        'gambar',
        'image',
        'created_by',
        'is_published',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->judul);
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getImageAttribute($value)
    {
        return $value ?? ($this->attributes['gambar'] ?? null);
    }

    public function getGambarAttribute($value)
    {
        return $value ?? ($this->attributes['image'] ?? null);
    }

    public function getImageUrlAttribute(): ?string
    {
        $imagePath = $this->image ?? $this->gambar;

        if (! $imagePath) {
            return 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800&auto=format&fit=crop&q=80';
        }

        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return $imagePath;
        }

        if (\Storage::disk('public')->exists($imagePath)) {
            return asset('storage/' . ltrim($imagePath, '/'));
        }

        return 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800&auto=format&fit=crop&q=80';
    }

    public function getExcerptAttribute(): string
    {
        return Str::limit(strip_tags($this->konten), 160);
    }
}
