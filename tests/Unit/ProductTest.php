<?php

namespace Tests\Unit;


use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @test
     */
    public function create_success()
    {
        Product::create([
            'title' => 'Je suis un produit',
            'slug' => 'je-suis-un-produit',
            'excerpt' => 'présentation r\'apide de produit',
            'description' => 'présentation plus conpplete du produit, et bien d\'étailler ',
            'price' => 14.5,
            'image' => 'urlduneimage'
        ]);

        $this->assertCount(1, Product::all());
    }
    /**
     *
     * @test
     */
    public function updated_success()
    {
       $product = Product::create([
            'title' => 'Je suis un produit',
            'slug' => 'je-suis-un-produit',
            'excerpt' => 'présentation r\'apide de produit',
            'description' => 'présentation plus conpplete du produit, et bien d\'étailler ',
            'price' => 14.5,
            'image' => 'urlduneimage'
        ]);
       $this->assertCount(1, Product::all());

       $newTile = 'Nouveeau titre';

       $product->update([
           'title' => $newTile
       ]);
       $this->assertEquals($newTile, $product->title);
       $this->assertCount(1, Product::all());

    }

    /**
     * @test
     */
    public function deleted_success()
    {
        $product = Product::create([
            'title' => 'Je suis un produit',
            'slug' => 'je-suis-un-produit',
            'excerpt' => 'présentation r\'apide de produit',
            'description' => 'présentation plus conpplete du produit, et bien d\'étailler ',
            'price' => 14.5,
            'image' => 'urlduneimage'
        ]);
        $this->assertCount(1, Product::all());

        $product->delete();
        $this->assertCount(0, Product::all());
    }
}
