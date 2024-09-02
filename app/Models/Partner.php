<?php

namespace App\Models;

use App\Helpers\Loggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Partner extends Model implements TranslatableContract, HasMedia
{
    use Translatable, Loggable, InteractsWithMedia, NodeTrait;

    public array $translatedAttributes = ['title', 'link'];

    protected $fillable = ['active', 'review', 'show_in_block'];

}
