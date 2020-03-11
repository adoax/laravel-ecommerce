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
Route::get('search', 'ProductController@search')->name('product.search');

/** Route Cart */
Route::post('panier/ajouter', 'CartController@store')->name('cart.store');
Route::get('panier', "CartController@index")->name('cart.index');
Route::patch('panier/{cart}', 'CartController@update')->name('cart.update');
Route::delete('panier/{cart}', "CartController@destroy")->name('cart.destroy');

/** Route checkout */
Route::get('paiement', 'CheckoutController@index')->name('checkout.index');
Route::post('paiement', 'CheckoutController@store')->name('checkout.store');
Route::get('merci', 'CheckoutController@thankYou')->name('checkout.thank');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
