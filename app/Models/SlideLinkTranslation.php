<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SlideLinkTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'link'];
}
