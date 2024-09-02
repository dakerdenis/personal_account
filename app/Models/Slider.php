<?php

namespace App\Models;

use App\Helpers\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slider extends Model
{
    use Loggable;

    protected $fillable = [
        'name', 'machine_name'
    ];

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
    }

}
