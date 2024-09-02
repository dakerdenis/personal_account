<?php

namespace App\Models;

use App\Helpers\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Brand extends Model implements HasMedia
{
    use InteractsWithMedia, Loggable, NodeTrait;

    protected $fillable = ['title', 'active', 'link'];

    public function getGeneratedLinkAttribute(): string
    {
        return route('brand', $this);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->nonOptimized()
            ->performOnCollections('preview')
            ->format('webp');
    }
}
