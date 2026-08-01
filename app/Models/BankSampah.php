<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BankSampah extends Model
{
    use SoftDeletes;

    protected $table = 'bank_sampahs';

    protected $fillable = [
        'kode_bank',
        'nama',
        'slug',
        'logo',
        'foto',
        'deskripsi',
        'email',
        'telepon',
        'whatsapp',
        'website',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'kode_pos',
        'latitude',
        'longitude',
        'jam_buka',
        'jam_tutup',
        'hari_operasional',
        'radius_layanan',
        'wilayah_layanan',
        'status',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'radius_layanan' => 'integer',
        'wilayah_layanan' => 'array',
    ];

    protected $appends = ['logo_url', 'foto_url', 'status_badge_bg', 'marker_color'];

    // ─── Relationships ───

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function nasabah(): HasMany
    {
        return $this->hasMany(User::class)->whereHas('roles', function ($q) {
            $q->where('name', 'nasabah');
        });
    }

    public function petugas(): HasMany
    {
        return $this->hasMany(User::class)->whereHas('roles', function ($q) {
            $q->where('name', 'petugas');
        });
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, User::class, 'bank_sampah_id', 'user_id');
    }

    public function trashCategories(): HasMany
    {
        return $this->hasMany(TrashCategory::class);
    }

    public function scanLogs(): HasMany
    {
        return $this->hasMany(ScanLog::class);
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    // ─── Scopes ───

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeByWilayah($query, ?string $provinsi = null, ?string $kabupaten = null, ?string $kecamatan = null)
    {
        if ($provinsi) $query->where('provinsi', 'like', "%{$provinsi}%");
        if ($kabupaten) $query->where('kabupaten', 'like', "%{$kabupaten}%");
        if ($kecamatan) $query->where('kecamatan', 'like', "%{$kecamatan}%");
        return $query;
    }

    public function scopeSearch($query, ?string $search)
    {
        if (!$search) return $query;
        return $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('kode_bank', 'like', "%{$search}%")
              ->orWhere('alamat', 'like', "%{$search}%")
              ->orWhere('kecamatan', 'like', "%{$search}%")
              ->orWhere('kabupaten', 'like', "%{$search}%")
              ->orWhere('provinsi', 'like', "%{$search}%");
        });
    }

    // ─── Accessors & Helpers ───

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && str_starts_with($this->logo, 'http')) return $this->logo;
        if ($this->logo && file_exists(storage_path('app/public/' . $this->logo))) return asset('storage/' . $this->logo);
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=22C55E&color=fff&size=128';
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && str_starts_with($this->foto, 'http')) return $this->foto;
        if ($this->foto) return asset('storage/' . $this->foto);
        return asset('images/bank-sampah-default-bg.jpg');
    }

    public function getStatusBadgeBgAttribute(): string
    {
        return match ($this->status) {
            'aktif' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'libur' => 'bg-amber-100 text-amber-800 border-amber-300',
            'nonaktif' => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-slate-100 text-slate-800 border-slate-300',
        };
    }

    public function getMarkerColorAttribute(): string
    {
        return match ($this->status) {
            'aktif' => '#10b981', // Green
            'libur' => '#f59e0b', // Yellow
            'nonaktif' => '#ef4444', // Red
            default => '#6b7280',
        };
    }

    /**
     * Calculate Distance from user GPS (Haversine formula in kilometers)
     */
    public function calculateDistance(?float $userLat, ?float $userLng): float
    {
        if (!$userLat || !$userLng || !$this->latitude || !$this->longitude) return 0.0;
        
        $earthRadius = 6371; // radius in km
        $dLat = deg2rad($this->latitude - $userLat);
        $dLng = deg2rad($this->longitude - $userLng);
        
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($userLat)) * cos(deg2rad($this->latitude)) *
             sin($dLng / 2) * sin($dLng / 2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 2);
    }

    /**
     * Check if user coordinates fall inside this Bank Sampah's service radius
     */
    public function isWithinServiceRadius(?float $userLat, ?float $userLng): bool
    {
        $distanceKm = $this->calculateDistance($userLat, $userLng);
        $radiusKm = ($this->radius_layanan ?: 2000) / 1000;
        return $distanceKm <= $radiusKm;
    }

    /**
     * Check if Bank Sampah is open right now
     */
    public function isOpenNow(): bool
    {
        if ($this->status !== 'aktif') return false;
        
        $now = now();
        $buka = \Carbon\Carbon::createFromTimeString($this->jam_buka ?? '08:00');
        $tutup = \Carbon\Carbon::createFromTimeString($this->jam_tutup ?? '16:00');
        
        return $now->between($buka, $tutup);
    }

    /**
     * Boot model helper to generate unique kode_bank and slug
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->kode_bank)) {
                $maxId = static::max('id') + 1;
                $model->kode_bank = 'BS-' . str_pad((string)$maxId, 3, '0', STR_PAD_LEFT);
            }
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama) . '-' . Str::random(5);
            }
        });
    }
}
