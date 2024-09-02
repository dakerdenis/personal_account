<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchTranslation extends Model
{
    protected $fillable = ['title', 'address', 'work_hours'];
}
