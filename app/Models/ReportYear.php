<?php

namespace App\Models;

use App\Helpers\Loggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ReportYear extends Model implements TranslatableContract
{
    use Translatable, Loggable;

    public array $translatedAttributes = ['title'];

    protected $fillable = ['active', 'year'];

    public function reportGroups(): HasMany
    {
        return $this->hasMany(ReportGroup::class);
    }
}
