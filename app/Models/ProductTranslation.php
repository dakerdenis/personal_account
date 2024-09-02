<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $fillable = ['title', 'description', 'seo_keywords', 'meta_title', 'meta_description', 'statistics', 'sub_title',
        'calculator_title', 'form_title', 'packages_title', 'packages_description', 'banner', 'insurance_conditions_title', 'files_title'
    ];

    protected $casts = [
        'statistics' => 'object',
        'banner' => 'object',
    ];
}
