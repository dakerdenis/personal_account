<?php

namespace App\Models;

use App\Helpers\Loggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Branch extends Model implements TranslatableContract, HasMedia
{
    use Translatable, InteractsWithMedia, Loggable, NodeTrait;

    public array $translatedAttributes = ['title', 'address', 'work_hours'];
    protected $fillable = ['active', 'phone', 'email', 'latitude', 'longitude'];

    public function getLinkAttribute(): ?string
    {
        $branchCategory = Category::query()->where('taxonomy', Category::BRANCHES)->first();
        if (!$branchCategory) {
            return null;
        }
        return route('category', ['category' => $branchCategory->slug]);
    }

    public function getMasterAttribute()
    {
        $branchCategory = Category::query()->where('taxonomy', Category::BRANCHES)->first();
        if (!$branchCategory) {
            return null;
        }

        return $branchCategory->title;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit(Manipulations::FIT_CROP, 225, 225)->performOnCollections('preview');

        $this->addMediaConversion('thumbWebp')->fit(Manipulations::FIT_CROP, 225, 225)->performOnCollections('preview')->format('webp');

        $this->addMediaConversion('webp')->performOnCollections('preview')->format('webp');
    }
}
