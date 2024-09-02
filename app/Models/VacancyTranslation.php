<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacancyTranslation extends Model
{
    protected $fillable = ['title', 'description', 'requirements', 'conditions', 'contacts'];
}
