<?php

namespace Database\Seeders\Categories;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Output\ConsoleOutput;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'title' => 'News',
                'taxonomy' => Category::BLOG,
                'slug' => 'news',
                'active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $output = new ConsoleOutput();
        $output->writeln("<fg=red>Categories and values created</>");
    }
}
