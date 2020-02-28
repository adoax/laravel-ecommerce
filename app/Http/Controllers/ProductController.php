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

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }
}
