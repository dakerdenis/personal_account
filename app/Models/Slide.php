<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Slide extends Model implements TranslatableContract, Sortable, HasMedia
{
    use SortableTrait, Translatable, HasAuthor, InteractsWithMedia;

    public array $translatedAttributes = ['title', 'link', 'description', 'button_text'];

    public array $sortable = [
        'order_column_name'  => 'order_column',
        'sort_when_creating' => false,
    ];

    protected $fillable = ['order_column', 'staff_id', 'slider_id'];

    public function slideLinks(): HasMany
    {
        return $this->hasMany(SlideLink::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('minWebp')->fit(Manipulations::FIT_CROP, 500, 220)->performOnCollections('preview')->format('webp');
        $this->addMediaConversion('mdWebp')->fit(Manipulations::FIT_CROP, 768, 320)->performOnCollections('preview')->format('webp');
        $this->addMediaConversion('lgWebp')->fit(Manipulations::FIT_CROP, 800, 440)->performOnCollections('preview')->format('webp');
        $this->addMediaConversion('xlWebp')->fit(Manipulations::FIT_CROP, 640, 311)->performOnCollections('preview')->format('webp');
        $this->addMediaConversion('xxlWebp')->fit(Manipulations::FIT_CROP, 984, 525)->performOnCollections('preview')->format('webp');
        $this->addMediaConversion('webp')->nonOptimized()->performOnCollections('preview')->format('webp');
    }
}
