<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class ProductFeature extends Model implements Sortable, TranslatableContract
{
    use SortableTrait, Translatable;

    public array $translatedAttributes = ['title', 'description'];
    protected $fillable = ['order_column', 'product_id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function featureLines(): HasMany
    {
        return $this->hasMany(FeatureLine::class)->orderBy('order_column');
    }
}
