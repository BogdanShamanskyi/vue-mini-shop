<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $categories = Category::query()->get(['id']);
        if ($categories->isEmpty()) {
            return;
        }

        for ($i = 0; $i < 100; $i++) {
            $price = $faker->randomFloat(2, 10, 5000);

            Product::query()->create([
                'category_id' => $categories->random()->id,
                'title' => $faker->words(3, true),
                'description' => $faker->paragraph(3),
                'price' => $price,
                'stock' => $faker->numberBetween(0, 50),
            ]);
        }
    }
}
