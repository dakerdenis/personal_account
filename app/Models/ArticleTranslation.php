<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTranslation extends Model
{
    public $fillable = ['title', 'description', 'seo_keywords', 'short_description', 'bottom_text', 'subtitle'];
}
