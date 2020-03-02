<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

/** Route product */
Route::resource('produits', 'ProductController')->parameters([
    'produits' => 'product'
]);

/** Route Cart */
Route::get('panier/ajouter', 'CartController@store')->name('cart.store');
Route::get('panier', "CartController@index")->name('cart.index');
Route::delete('panier/{cart}', "CartController@destroy")->name('cart.destroy');
//Route::resource('panier', 'CartController');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
