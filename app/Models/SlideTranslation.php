<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlideTranslation extends Model
{
    protected $fillable = ['title', 'link', 'description', 'button_text'];
}
