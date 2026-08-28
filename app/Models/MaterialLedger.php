<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_sampah_id',
        'trash_category_id',
        'tipe',
        'tipe_label',
        'kategori_nama',
        'berat_kg',
        'nilai_rp',
        'output_desc',
        'pihak_terkait',
        'status',
    ];

    protected $casts = [
        'berat_kg' => 'float',
        'nilai_rp' => 'float',
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
