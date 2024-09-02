<?php

namespace App\Repository\Settings;

use App\Repository\SettingRepositoryInterface;
use Spatie\LaravelSettings\Settings;

class SettingRepository implements SettingRepositoryInterface
{
    public function __construct(protected Settings $settings)
    {

    }
}
