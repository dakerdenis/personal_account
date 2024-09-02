<?php

namespace App\Services;

class LocalizationService
{
    public static function getLocalesOrder()
    {
        return config('laravellocalization.allLocales');
    }
}
