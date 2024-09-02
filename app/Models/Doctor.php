<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'external_id',
        'speciality_id',
        'speciality_title',
        'name',
        'workplace',
        'image64',
        'rating'
    ];
}
