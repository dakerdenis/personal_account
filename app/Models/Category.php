<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\Loggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements TranslatableContract, HasMedia
{
    use Translatable, HasAuthor, Loggable, NodeTrait, InteractsWithMedia;

    public const BLOG = 'blog';
    public const REPORTS = 'reports';
    public const PARTNERS = 'partners';
    public const VACANCIES = 'vacancies';
    public const PRODUCTS = 'products';
    public const MANAGEMENT = 'management';
    public const BRANCHES = 'branches';
    public const FAQ = 'faq';
    public const SPECIAL_OFFERS = 'special_offers';
    public const DOCTORS = 'doctors';

    public static array $terms = [
        self::BLOG       => 'blog',
        self::REPORTS    => self::REPORTS,
        self::PARTNERS   => 'partners',
        self::VACANCIES  => 'vacancies',
        self::PRODUCTS   => 'products',
        self::MANAGEMENT => 'management',
        self::BRANCHES   => 'branches',
        self::DOCTORS   => 'doctors',
        self::FAQ        => self::FAQ,
        self::SPECIAL_OFFERS        => self::SPECIAL_OFFERS,
    ];

    public array $translatedAttributes = ['title', 'description', 'seo_keywords', 'meta_description'];

    protected $fillable = ['id', 'slug', 'active', 'taxonomy', 'staff_id', 'show_date_on_articles'];

    protected $with = ['translations'];

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function setActiveAttribute($value)
    {
        $this->attributes['active'] = boolval($value);
    }

    public function articles(): MorphToMany
    {
        return $this->morphedByMany(Article::class, 'categorable');
    }

    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'categorable');
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        if ($childType === 'vacancy') {
            return Vacancy::where($field, $value)->where('active', true)->firstOrFail();
        }

        return parent::resolveChildRouteBinding($childType, $value, $field);
    }

    public function getLinkAttribute(): string
    {
        return route('category', ['category' => $this->slug]);
    }

    public function getMasterAttribute()
    {
        if (!$this->parent_id) {
            return null;
        }

        return $this->ancestors()->first()->title;
    }

    //protected function resolveChildRouteBindingQuery($childType, $value, $field): bool|\Illuminate\Database\Eloquent\Relations\Relation
    //{
    //    if ($childType === 'vacancy') {
    //        return true;
    //    }
    //
    //    return parent::resolveChildRouteBindingQuery($childType, $value, $field);
    //}

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')->nonOptimized()->performOnCollections('preview')->format('webp');
        $this->addMediaConversion('thumb')->height(300)->fit(Manipulations::FIT_CROP, 500, 300)->format('webp');
    }
}
