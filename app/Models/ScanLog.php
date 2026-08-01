<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanLog extends Model
{
    protected $fillable = [
        'user_id',
        'foto_path',
        'trash_category_id',
        'ai_detected_nama',
        'ai_detected_kategori',
        'confidence',
        'total_harga',
        'total_berat',
        'object_count',
        'eco_impact',
        'items_detail',
        'ai_raw_response',
        'status',
    ];

    protected $casts = [
        'ai_raw_response' => 'array',
        'eco_impact' => 'array',
        'items_detail' => 'array',
        'confidence' => 'float',
        'total_harga' => 'decimal:2',
        'total_berat' => 'decimal:2',
        'object_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trashCategory()
    {
        return $this->belongsTo(TrashCategory::class);
    }
}
