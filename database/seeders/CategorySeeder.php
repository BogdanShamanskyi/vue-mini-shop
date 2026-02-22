<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles = [
            'Electronics',
            'Home',
            'Books',
            'Sports',
            'Toys',
        ];

        foreach ($titles as $title) {
            Category::query()->create(['title' => $title]);
        }
    }
}
