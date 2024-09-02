<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Loggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UsefulLink extends Model implements TranslatableContract, HasMedia
{
    use Translatable, Loggable, InteractsWithMedia;

    public array $translatedAttributes = ['title'];

    protected $fillable = ['link', 'active'];
}
