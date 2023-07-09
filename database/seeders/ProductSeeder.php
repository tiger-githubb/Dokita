<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            Product::create([
                'price' => $faker->numberBetween(1000, 10000),
                'country' => $faker->country,
                'city' => $faker->city,
                'no_rooms' => $faker->randomNumber(1),
                'no_bedrooms' => $faker->randomNumber(1),
                'no_bathrooms' => $faker->randomNumber(1),
                'surface_area' => $faker->numberBetween(50, 200),
                'no_garages' => $faker->randomNumber(1),
                'images' => $faker->imageUrl(),
                'type' => $faker->randomElement(['apartment', 'villa', 'house', 'land']),
                'status' => $faker->randomElement(['sale', 'rent']),
            ]);
        }
    }
}
