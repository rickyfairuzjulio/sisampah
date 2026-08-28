<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfftakerSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_sampah_id',
        'trash_category_id',
        'admin_id',
        'nama_pembeli',
        'berat_kg',
        'harga_per_kg',
        'total_pendapatan',
        'foto_nota',
        'catatan',
        'status',
    ];

    protected $casts = [
        'berat_kg' => 'float',
        'harga_per_kg' => 'float',
        'total_pendapatan' => 'float',
    ];

    public function bankSampah()
    {
        return $this->belongsTo(BankSampah::class);
    }

    public function trashCategory()
    {
        return $this->belongsTo(TrashCategory::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
