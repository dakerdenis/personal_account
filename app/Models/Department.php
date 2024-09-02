<?php

namespace App\Models;

use App\Helpers\Loggable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Kalnoy\Nestedset\NodeTrait;

class Department extends Model implements TranslatableContract
{
    use NodeTrait, Translatable, Loggable;

    public array $translatedAttributes = ['title'];

    protected $fillable = ['active'];
}
