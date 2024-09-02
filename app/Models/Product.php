<?php

namespace App\Models;

use App\Calculators\CascoCalculator;
use App\Calculators\PersonalInsuranceCalculator;
use App\Forms\BasicForm;
use App\Forms\FormAbstract;
use App\Helpers\Loggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Image\Manipulations;
use Spatie\LaravelPackageTools\Package;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Product extends Model implements TranslatableContract, HasMedia
{
    use Translatable, InteractsWithMedia, Loggable, NodeTrait;

    public const TYPE_PRODUCT = 'product';
    public const TYPE_PACKAGE = 'package';
    public const TYPES = [
        self::TYPE_PRODUCT => 'Product',
        self::TYPE_PACKAGE => 'Package',
    ];
    public const FORMS = [
        BasicForm::class => BasicForm::FORM_NAME,
    ];
    public const CALCULATORS = [
        CascoCalculator::class => CascoCalculator::CALCULATOR_NAME,
        PersonalInsuranceCalculator::class => PersonalInsuranceCalculator::CALCULATOR_NAME,
    ];
    public array $translatedAttributes = [
        'title',
        'description',
        'seo_keywords',
        'meta_title',
        'meta_description',
        'sub_title',
        'statistics',
        'calculator_title',
        'form_title',
        'packages_title',
        'packages_description',
        'banner',
        'insurance_conditions_title',
        'files_title',
    ];
    protected $fillable = [
        'form',
        'form_receivers',
        'calculator',
        'active',
        'slug',
        'type',
    ];

    public function getLinkAttribute(): string
    {
        return route('product', ['product' => $this->slug, 'category' => $this->categories()->first()->slug]);
    }

    public function getForm(): ?FormAbstract
    {
        return ($this->attributes['form'] ?? false) ? new $this->attributes['form']($this) : null;
    }

    public function getCalculator()
    {
        return ($this->attributes['calculator'] ?? false) ? new $this->attributes['calculator']($this) : null;
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorable');
    }

    public function insuranceConditions(): HasMany
    {
        return $this->hasMany(InsuranceCondition::class);
    }

    public function productFeatures(): HasMany
    {
        return $this->hasMany(ProductFeature::class)->orderBy('order_column');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class);
    }

    public function usefulLinks(): BelongsToMany
    {
        return $this->belongsToMany(UsefulLink::class)->withPivot('order')->orderBy('order');
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class)->withPivot('order')->orderBy('order');
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_package', 'product_id', 'package_id')->withPivot('order')->orderBy('order');
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class)->withPivot('order')->orderBy('order');
    }

    public function getHierarchyAttribute()
    {
        $hierarchy = [];
        $category = $this->categories->first();
        if ($category->parent_id) {
            $parent = Category::find($category->parent_id);
            $hierarchy[] = $parent->title;
        }
        $hierarchy[] = $category->title;

        return $hierarchy;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')->format('webp');
        $this->addMediaConversion('thumb')->height(318)->fit(Manipulations::FIT_CROP, 500, 318)->format('webp');
    }
}
