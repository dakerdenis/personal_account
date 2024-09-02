<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\Loggable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Kalnoy\Nestedset\NodeTrait;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MenuItem extends Model implements HasMedia
{
    use HasFactory, NodeTrait, Translatable, HasAuthor, Loggable, InteractsWithMedia;

    public array $translatedAttributes = ['title', 'sub_title', 'seo_keywords'];

    protected $fillable = ['slug', 'navigation_id', 'active', 'staff_id', 'is_mega_menu', 'selected'];

    protected $with = ['translations'];

    public function scopeActive($query): mixed
    {
        return $query->where('active', 1);
    }

    public function getGeneratedLinkAttribute(): string
    {
        return $this->slug !== '#' ? (str_starts_with($this->slug, 'http') ? $this->slug : LaravelLocalization::getLocalizedURL(App::getLocale(), $this->slug)) : 'javascript:void(0);';
    }

    public function getTargetAttribute(): string
    {
        return $this->slug !== '#' ? (str_starts_with($this->slug, 'http') ? '_blank' : '_self') : '_self';
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('min')
            ->nonOptimized()
            ->fit(Manipulations::FIT_CROP, 500, 500)
            ->performOnCollections('preview');

        $this->addMediaConversion('minWebp')
            ->nonOptimized()
            ->fit(Manipulations::FIT_CROP, 500, 500)
            ->performOnCollections('preview')
            ->format('webp');

        $this->addMediaConversion('md')
            ->nonOptimized()
            ->fit(Manipulations::FIT_CROP, 1024, 384)
            ->performOnCollections('preview');

        $this->addMediaConversion('mdWebp')
            ->nonOptimized()
            ->fit(Manipulations::FIT_CROP, 1024, 384)
            ->performOnCollections('preview')
            ->format('webp');

        $this->addMediaConversion('lg')
            ->nonOptimized()
            ->fit(Manipulations::FIT_CROP, 1366, 500)
            ->performOnCollections('preview');

        $this->addMediaConversion('lgWebp')
            ->nonOptimized()
            ->fit(Manipulations::FIT_CROP, 1366, 500)
            ->performOnCollections('preview')
            ->format('webp');

        $this->addMediaConversion('webp')
            ->nonOptimized()
            ->performOnCollections('preview')
            ->format('webp');
    }

}
