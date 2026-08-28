<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_sampah_id',
        'trash_category_id',
        'stok_kg',
        'kapasitas_maks_kg',
        'lokasi_rak',
        'status_kondisi',
    ];

    protected $casts = [
        'stok_kg' => 'float',
        'kapasitas_maks_kg' => 'float',
    ];

    public function bankSampah()
    {
        return $this->belongsTo(BankSampah::class);
    }

    public function trashCategory()
    {
        return $this->belongsTo(TrashCategory::class);
    }
}
