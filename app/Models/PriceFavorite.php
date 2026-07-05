<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'trash_category_id'])]
class PriceFavorite extends Model
{
    // ─── Relationships ───

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trashCategory(): BelongsTo
    {
        return $this->belongsTo(TrashCategory::class);
    }
}
