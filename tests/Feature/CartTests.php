<?php

namespace Tests\Feature;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTests extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function add_unique_product_cart()
    {
        $product = factory(Product::class)->create();

        $response = $this->post(route('cart.store'), [
            'id' => $product->id
        ]);

        $this->assertEquals(1, Cart::count());
    }

    /** @test */
    public function add_multiple_product_cart()
    {
        $product = factory(Product::class, 4)->create();

        $this->post(route('cart.store'), [
            'id' => Product::first()->id
        ]);

        $this->post(route('cart.store'), [
            'id' => Product::find(2)->id
        ]);

        $this->assertEquals(2, Cart::count());

    }

    /** @test */
    public function add_multiple_identical_product()
    {
        $product = factory(Product::class)->create();

        $this->post(route('cart.store'), [
            'id' => $product->id
        ]);

        $this->assertEquals(1, Cart::count());

        $this->json('PATCH', route('cart.update', '027c91341fd5cf4d2579b49c4b6a90da'), [
            'qty' => 2
        ]);

        $this->assertEquals(2, Cart::count());
    }

    /** @test */
    public function delete_product_cart()
    {
        $product = factory(Product::class)->create();

        $this->post(route('cart.store'), [
            'id' => $product->id
        ]);
        $this->assertEquals(1, Cart::count());

        $productCart = Cart::content()->first();

        $this->delete(route('cart.destroy', $productCart->rowId));
        $this->assertEquals(0, Cart::count());
    }

    /** @test */
    public function delete_choices_multiple_product_cart()
    {
        $product = factory(Product::class, 4)->create();

        $this->post(route('cart.store'), [
            'id' => Product::first()->id
        ]);

        $this->post(route('cart.store'), [
            'id' => Product::find(2)->id
        ]);

        $this->assertEquals(2, Cart::count());

    }


}
