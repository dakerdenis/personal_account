<?php

namespace App\Models;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class InsuranceCondition extends Model implements TranslatableContract, HasMedia, Sortable
{
    use InteractsWithMedia, Translatable, SortableTrait;

    public array $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => false,
    ];

    public array $translatedAttributes = ['title', 'description'];
    protected $fillable = ['order_column', 'product_id'];
}
