<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Kalnoy\Nestedset\NodeTrait;

class InsuranceType extends Model implements TranslatableContract
{
    use Translatable, NodeTrait;

    public array $translatedAttributes = ['title'];

    protected $fillable = ['active', 'form_recipients'];
}
