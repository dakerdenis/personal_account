<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepeatableTranslation extends Model
{
    public $fillable = ['title', 'data'];

    protected $casts = [
        'data' => 'array',
    ];
}
