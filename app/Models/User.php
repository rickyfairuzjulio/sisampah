<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'saldo', 'avatar', 'rt', 'rw', 'alamat_lengkap', 'nomor_telepon', 'bank_sampah_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'saldo' => 'decimal:2',
        ];
    }

    public function bankSampah()
    {
        return $this->belongsTo(BankSampah::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function petugasTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'petugas_id');
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function topups(): HasMany
    {
        return $this->hasMany(TopUp::class);
    }

    public function leaderboard(): HasOne
    {
        return $this->hasOne(Leaderboard::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'created_by');
    }

    public function priceFavorites(): HasMany
    {
        return $this->hasMany(PriceFavorite::class);
    }

    public function priceNotifications(): HasMany
    {
        return $this->hasMany(PriceNotification::class);
    }

    public function priceHistories(): HasMany
    {
        return $this->hasMany(PriceHistory::class, 'admin_id');
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return \Illuminate\Support\Facades\Storage::url($this->avatar);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=059669&color=fff&rounded=true&bold=true';
    }
}
