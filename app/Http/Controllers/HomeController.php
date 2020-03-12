<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\InteractsWithTime;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::inRandomOrder()->take(2)->get();
        $categories = Category::all();

        return view('index', compact('products', 'categories'));
    }

    public function command()
    {
        return view('users.command', ['orders' => Auth::user()->orders]);
    }
}
