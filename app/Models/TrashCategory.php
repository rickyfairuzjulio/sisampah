<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'nama', 'kode', 'kategori', 'jenis', 'gambar', 'harga_per_kg', 'harga_per_gram',
    'satuan', 'kualitas', 'stok_dibutuhkan', 'status_harga', 'perubahan_persen',
    'deskripsi', 'manfaat', 'nilai_daur_ulang', 'tips_penyimpanan', 'tips_menjual',
    'is_archived',
])]
class TrashCategory extends Model
{
    use SoftDeletes;

    protected $appends = ['image_url', 'kategori_label', 'price_status_bg', 'price_status_icon', 'price_status_color'];

    protected function casts(): array
    {
        return [
            'harga_per_kg' => 'decimal:2',
            'harga_per_gram' => 'decimal:4',
            'stok_dibutuhkan' => 'decimal:2',
            'perubahan_persen' => 'decimal:2',
            'is_archived' => 'boolean',
        ];
    }

    // ─── Relationships ───

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function priceHistories(): HasMany
    {
        return $this->hasMany(PriceHistory::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(PriceFavorite::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(PriceNotification::class);
    }

    // ─── Accessors ───

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

    public function getPriceStatusColorAttribute(): string
    {
        return match ($this->status_harga) {
            'naik' => 'text-green-600',
            'turun' => 'text-red-600',
            'stabil' => 'text-gray-500',
            default => 'text-gray-500',
        };
    }

    public function getPriceStatusBgAttribute(): string
    {
        return match ($this->status_harga) {
            'naik' => 'bg-green-100 text-green-800',
            'turun' => 'bg-red-100 text-red-800',
            'stabil' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-yellow-100 text-yellow-800',
        };
    }

    public function getPriceStatusIconAttribute(): string
    {
        return match ($this->status_harga) {
            'naik' => '↑',
            'turun' => '↓',
            'stabil' => '→',
            default => '→',
        };
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'organik' => 'Organik',
            'anorganik' => 'Anorganik',
            'b3' => 'B3',
            default => ucfirst($this->kategori ?? ''),
        };
    }

    // ─── Scopes ───

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeByKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeByJenis($query, string $jenis)
    {
        return $query->where('jenis', 'like', "%{$jenis}%");
    }

    public function scopeByStatusHarga($query, string $status)
    {
        return $query->where('status_harga', $status);
    }

    public function scopePriceRange($query, ?float $min, ?float $max)
    {
        if ($min !== null) {
            $query->where('harga_per_kg', '>=', $min);
        }
        if ($max !== null) {
            $query->where('harga_per_kg', '<=', $max);
        }

        return $query;
    }

    public function scopeSearch($query, ?string $search)
    {
        if (! $search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
                ->orWhere('kode', 'like', "%{$search}%")
                ->orWhere('jenis', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }

    // ─── Helpers ───

    public static function generateKode(string $nama): string
    {
        $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $nama), 0, 3));
        $count = static::where('kode', 'like', "{$prefix}-%")->count() + 1;

        return "{$prefix}-".str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    public function syncHargaPerGram(): void
    {
        $this->harga_per_gram = $this->harga_per_kg / 1000;
        $this->saveQuietly();
    }
}
