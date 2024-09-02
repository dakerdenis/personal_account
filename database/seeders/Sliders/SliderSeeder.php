<?php

namespace Database\Seeders\Sliders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run()
    {
        Slider::create([
            'name' => 'Main Slider',
            'machine_name' => 'main_slider',
        ]);
    }
}
