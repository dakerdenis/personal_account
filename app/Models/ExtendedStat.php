<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ExtendedStat extends Model implements TranslatableContract, HasMedia, Sortable
{
    use InteractsWithMedia, Translatable, SortableTrait;

    public array $sortable = [
        'order_column_name'  => 'order_column',
        'sort_when_creating' => true,
    ];

    public array $translatedAttributes = ['title'];

    protected $fillable = ['order_column'];

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    public function extendedStatInfos(): HasMany
    {
        return $this->hasMany(ExtendedStatInfo::class);
    }


    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbStatistics')->width(443)->format('webp');
    }
}
