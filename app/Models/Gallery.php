<?php

namespace App\Models;

use App\Helpers\Loggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Gallery extends Model implements HasMedia
{
    use Loggable, InteractsWithMedia;

    protected $fillable = ['title'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('fullHD')
            ->nonOptimized()
            ->fit(Manipulations::FIT_MAX, 1920, 1080);

        $this->addMediaConversion('thumb')
            ->nonOptimized()
            ->fit(Manipulations::FIT_CROP, 515, 370);

        $this->addMediaConversion('thumbWebp')
            ->nonOptimized()
            ->fit(Manipulations::FIT_CROP, 515, 370)
            ->format('webp');

    }
}
