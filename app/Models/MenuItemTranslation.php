<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'sub_title', 'seo_keywords'];
}
