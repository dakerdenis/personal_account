<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['title', 'address', 'description', 'working_hours', 'sub_title'];

    protected $fillable = ['phones', 'email', 'short_number', 'latitude', 'longitude', 'social_networks', 'google_play_link', 'app_store_link'];

    protected $casts = [
        'social_networks' => 'object',
    ];
}
