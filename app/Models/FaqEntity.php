<?php

namespace App\Models;

use App\Helpers\Loggable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Kalnoy\Nestedset\NodeTrait;

class FaqEntity extends Model implements TranslatableContract
{
    use Translatable, NodeTrait, Loggable;

    public array $translatedAttributes = ['title', 'description'];

    protected $fillable = ['active'];

    public function getLinkAttribute(): ?string
    {
        $branchCategory = Category::query()->where('taxonomy', Category::FAQ)->first();
        if (!$branchCategory) {
            return null;
        }

        return route('category', ['category' => $branchCategory->slug]);
    }

    public function getMasterAttribute()
    {
        $branchCategory = Category::query()->where('taxonomy', Category::FAQ)->first();
        if (!$branchCategory) {
            return null;
        }

        return $branchCategory->title;
    }
}
