<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable(['judul', 'slug', 'konten', 'kategori', 'gambar', 'created_by', 'is_published'])]
class Article extends Model
{
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

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->gambar) {
            return null;
        }

        if (str_starts_with($this->gambar, 'http')) {
            return $this->gambar;
        }

        return asset('storage/'.$this->gambar);
    }

    public function getExcerptAttribute(): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->konten), 160);
    }
}
