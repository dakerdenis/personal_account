<?php

namespace App\Models;

use App\Helpers\Loggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model implements TranslatableContract
{
    use Translatable, Loggable;

    public array $translatedAttributes = ['title', 'description', 'path'];

    protected $fillable = ['active'];

    public function getLinkAttribute(): string
    {
        return Storage::url($this->path);
    }
}
