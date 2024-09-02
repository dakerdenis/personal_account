<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class SlideLink extends Model implements TranslatableContract, Sortable
{
    use SortableTrait, Translatable;

    public array $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => false,
    ];

    public array $translatedAttributes = ['title', 'link'];

    protected $fillable = ['order_column', 'slide_id'];
}
