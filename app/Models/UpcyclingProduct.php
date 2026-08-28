<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpcyclingProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_sampah_id',
        'trash_category_id',
        'nama_produk',
        'deskripsi',
        'bahan_baku_keterangan',
        'jumlah_bahan_kg',
        'stok_qty',
        'satuan',
        'harga_satuan',
        'total_valuasi',
        'pengrajin',
        'foto_url',
        'status',
    ];

    protected $casts = [
        'jumlah_bahan_kg' => 'float',
        'stok_qty' => 'integer',
        'harga_satuan' => 'float',
        'total_valuasi' => 'float',
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
