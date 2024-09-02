<?php

namespace App\Models;

use App\Helpers\Loggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kalnoy\Nestedset\NodeTrait;

class ReportGroup extends Model implements TranslatableContract
{
    use NodeTrait, Translatable, Loggable;

    public array $translatedAttributes = ['title'];

    protected $fillable = ['active', 'report_year_id'];

    public function reportYear(): BelongsTo
    {
        return $this->belongsTo(ReportYear::class);
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class)->withPivot('order')->orderBy('order');
    }
}
