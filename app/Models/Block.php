<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\Loggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Block extends Model implements TranslatableContract, HasMedia
{
    use HasFactory, Translatable, InteractsWithMedia, Loggable, HasAuthor;

    public const QUOTE = 'quote';
    public const STATISTICS = 'statistics';
    public const INDICATORS = 'indicators';
    public const GENERAL_INFO = 'general_info';
    public const BANNER = 'banner';
    public const APP_BANNER = 'app_banner';
    public const NEWS = 'news';
    public const SPECIAL_OFFERS = 'special_offers';
    public const SIDE_APP_BANNER = 'side_app_banner';
    public const SIDE_ICON_LINKS = 'side_icon_links';
    public const PARTNERS = 'partners';

    public static array $types = [
        self::QUOTE           => 'Quote',
        self::INDICATORS      => 'Indicators',
        self::STATISTICS      => 'Statistics',
        self::GENERAL_INFO    => 'General info',
        self::BANNER          => 'Banner',
        self::APP_BANNER      => 'App Banner',
        self::SPECIAL_OFFERS  => 'Special Offers',
        self::NEWS            => 'News',
        self::PARTNERS        => 'Partners',
        self::SIDE_APP_BANNER => 'Static side applications links banner',
        self::SIDE_ICON_LINKS => 'Static side links with icons list',
    ];

    public array $translatedAttributes = ['title', 'data'];

    protected $fillable = ['type', 'unique', 'meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    protected $with = ['blockables'];

    public function blockables(): HasMany
    {
        return $this->hasMany(Blockable::class);
    }

    public function repeatables(): MorphMany
    {
        return $this->morphMany(Repeatable::class, 'repeatable');
    }

    public function extendedStats(): HasMany
    {
        return $this->hasMany(ExtendedStat::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')->nonOptimized()->format('webp');
        $this->addMediaConversion('thumbIndicators')->height(201)->fit(Manipulations::FIT_CROP, 500, 201)->format('webp');
    }

}
