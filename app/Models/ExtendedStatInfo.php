<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class ExtendedStatInfo extends Model implements TranslatableContract, Sortable
{
    use Translatable, SortableTrait;

    public array $sortable = [
        'order_column_name'  => 'order_column',
        'sort_when_creating' => true,
    ];

    public array $translatedAttributes = ['title', 'description'];

    protected $fillable = ['order_column'];
}
