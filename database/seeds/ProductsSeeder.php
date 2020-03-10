<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Product::class, 30)->create()->each(function ($product) {
            $product->categories()->attach([rand(1,5), rand(1, 5)]);
        });
    }
}
