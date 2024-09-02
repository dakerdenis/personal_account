<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactTranslation extends Model
{
    protected $fillable = ['title', 'address', 'description', 'working_hours', 'sub_title'];
}
