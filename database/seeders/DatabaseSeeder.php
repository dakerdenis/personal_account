<?php

namespace Database\Seeders;

use Database\Seeders\Categories\CategorySeeder;
use Database\Seeders\Contacts\ContactSeeder;
use Database\Seeders\Moderating\RolesAndPermissionSeeder;
use Database\Seeders\Navigation\NavigationSeeder;
use Database\Seeders\Sliders\SliderSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        (new RolesAndPermissionSeeder())->run();
        (new NavigationSeeder())->run();
        (new ContactSeeder())->run();
        (new CategorySeeder())->run();
        (new SliderSeeder())->run();
    }
}
