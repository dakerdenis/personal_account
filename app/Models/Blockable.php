<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\EloquentSortable\SortableTrait;

class Blockable extends Model
{
    use HasFactory, SortableTrait;

    protected $fillable = ['block_id', 'blockable_id', 'blockable_type', 'order_column'];

    /**
     * @return BelongsTo
     */
    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    public function blockable(): MorphTo
    {
        return $this->morphTo();
    }
}
