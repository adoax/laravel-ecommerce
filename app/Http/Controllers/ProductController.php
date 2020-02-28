<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('product.index', ['products' => Product::all()]);
    }

    /**
     * @param Product $product
     * @return Application|Factory|View
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        Product::create($request->all());
    }

    /**
     * @param Product $product
     * @param Request $request
     */
    public function update(Product $product, Request $request)
    {
        $product->update($request->all());
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}
