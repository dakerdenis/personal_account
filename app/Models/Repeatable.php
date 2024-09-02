<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Repeatable extends Model implements TranslatableContract, HasMedia, Sortable
{
    use Translatable, InteractsWithMedia, SortableTrait;

    public array $translatedAttributes = ['title', 'data'];
    public array $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => false,
    ];
    protected $fillable = ['repeatable_id', 'repeatable_type', 'meta', 'order_column'];
    protected $casts = [
        'meta' => 'array',
    ];

    public function repeatable(): MorphTo
    {
        return $this->morphTo();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->nonOptimized()
            ->performOnCollections('preview')
            ->format('webp');
    }
}
