<?php

namespace App\Models;

use App\Forms\CaseHappenedForm;
use App\Forms\ComplaintForm;
use App\Forms\FormAbstract;
use App\Helpers\HasAuthor;
use App\Helpers\Loggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class StaticPage extends Model implements TranslatableContract, HasMedia
{
    use HasFactory, Translatable, Loggable, HasAuthor, InteractsWithMedia, NodeTrait;

    public const FORMS = [
        ComplaintForm::class => ComplaintForm::FORM_NAME,
        CaseHappenedForm::class => CaseHappenedForm::FORM_NAME,
    ];

    public array $translatedAttributes = ['title', 'description', 'seo_keywords', 'subtitle'];

    protected $fillable = ['slug', 'active', 'user_id', 'gallery_id', 'youtube_tag', 'form'];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class)->withPivot('order')->orderBy('order');
    }

    public function usefulLinks(): BelongsToMany
    {
        return $this->belongsToMany(UsefulLink::class)->withPivot('order')->orderBy('order');
    }

    public function getForm(): ?FormAbstract
    {
        return ($this->attributes['form'] ?? false) ? new $this->attributes['form']($this) : null;
    }

    public function getLinkAttribute(): string
    {
        return route('static-page', ['staticPage' => $this->slug]);
    }


    public function getMasterAttribute()
    {
        $menuItem = MenuItem::query()->where('slug', '/pages/' . $this->slug)->first();
        if (!$menuItem) {
            return null;
        }

        return $menuItem->title;
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


        $this->addMediaConversion('webp')
            ->nonOptimized()
            ->performOnCollections('preview')
            ->format('webp');
    }
}
