<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class FeatureLine extends Model implements TranslatableContract, Sortable
{
    use SortableTrait, Translatable;

    public array $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => false,
    ];

    public array $translatedAttributes = ['description'];
    protected $fillable = ['order_column', 'product_feature_id'];
}
