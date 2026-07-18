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
        'ai_raw_response',
        'status',
    ];

    protected $casts = [
        'ai_raw_response' => 'array',
        'confidence' => 'float',
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
