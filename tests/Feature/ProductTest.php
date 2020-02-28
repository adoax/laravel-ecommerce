<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function create_success()
    {
        $response = $this->post(route('products.store'), [
            'title' => $this->faker->unique()->word(5),
            'slug' => $this->faker->unique()->slug,
            'excerpt' => $this->faker->sentence,
            'description' => $this->faker->text,
            'price' => $this->faker->numberBetween(15, 300) * 100,
            'image' => 'https://via.placeholder.com/200x250'
        ]);
        $response->assertStatus(200);
        $this->assertCount(1, Product::all());
    }

    /**
     * @test
     */
    public function updated_success()
    {
        $this->post(route('products.store'), [
            'title' => $this->faker->unique()->word(5),
            'slug' => $this->faker->unique()->slug,
            'excerpt' => $this->faker->sentence,
            'description' => $this->faker->text,
            'price' => $this->faker->numberBetween(15, 300) * 100,
            'image' => 'https://via.placeholder.com/200x250'
        ]);
        $product = Product::first();

        $newTile = $this->faker->unique()->word(5);
        $newdesc = $this->faker->text;

        $response = $this->patch(route('products.update', $product), [
            'title' => $newTile,
            'description' => $newdesc
        ]);

        $response->assertStatus(200);
        $this->assertEquals($newTile, Product::first()->title);
        $this->assertEquals($newdesc, Product::first()->description);
    }

    /** @test */
    public function delete_success()
    {
        $this->post(route('products.store'), [
            'title' => $this->faker->unique()->word(5),
            'slug' => $this->faker->unique()->slug,
            'excerpt' => $this->faker->sentence,
            'description' => $this->faker->text,
            'price' => $this->faker->numberBetween(15, 300) * 100,
            'image' => 'https://via.placeholder.com/200x250'
        ]);

        $this->assertCount(1, Product::all());
        $product = Product::first();

        $product->delete();

        $this->assertCount(0, Product::all());
    }
}
