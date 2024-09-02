<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\Loggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements TranslatableContract, HasMedia
{
    use Translatable, HasAuthor, Loggable, InteractsWithMedia, NodeTrait;

    public array $translatedAttributes = ['title', 'description', 'seo_keywords', 'short_description', 'bottom_text', 'subtitle'];

    protected $casts = [
        'date' => 'datetime',
        'end_date' => 'date',
    ];

    protected $fillable = ['slug', 'active', 'date', 'staff_id', 'archive', 'gallery_id', 'youtube_tag', 'end_date'];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorable');
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class)->withPivot('order')->orderBy('order');
    }

    public function usefulLinks(): BelongsToMany
    {
        return $this->belongsToMany(UsefulLink::class)->withPivot('order')->orderBy('order');
    }

    public function setActiveAttribute($value)
    {
        $this->attributes['active'] = boolval($value);
    }

    public function getLinkAttribute(): string
    {
        $slug = $this->categories->first()?->slug;
        if ($slug) {
            return route('article', ['category' => $slug, 'article' => $this->slug]);
        }

        return '';
    }

    public function getMasterAttribute(): string
    {
        return $this->categories->first()->title;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit(Manipulations::FIT_CROP, 385, 240)->performOnCollections('preview');

        $this->addMediaConversion('thumbWebp')->fit(Manipulations::FIT_CROP, 480, 480)->performOnCollections('preview')->format('webp');

        $this->addMediaConversion('webp')->performOnCollections('preview')->format('webp');
    }

}
