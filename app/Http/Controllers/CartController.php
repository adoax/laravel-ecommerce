<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('cart.index', ['carts' => Cart::content()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $cartExist = Cart::search(function($cartItem, $rowId) use ($request) {
           return $cartItem->id == $request->product_id;
        });

        if ($cartExist->isNotEmpty()) {
            return redirect()->route('produits.index')->with('warning', 'Le produit est dèja dans le panier');
        }
        $product = Product::find($request->product_id);
        Cart::add($product->id, $product->title, 1, $product->price)
            ->associate('App\Product');

        return redirect()->route('produits.index')->with('success', 'Le produit est bien éte ajouter');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->json()->all();

        $validates = Validator::make($request->all(), [
            'qty' => 'numeric|required|between:1,5',
        ]);

        if ($validates->fails()) {
            Session::flash('status', 'Une erreur est survenue veuillez réessayer');
            return response()->json(['warning' => 'Cart Quantity Has Not Been Updated']);
        }

        if ($data['qty'] > $data['stock']) {
            Session::flash('warning', 'La quantité de ce produit n\'est pas disponible');
            return response()->json(['error' => 'Cart Quantity Has Not Been Updated']);
        }

        Cart::update($id, $data['qty']);
        Session::flash('success', 'La quantité est bien ete modifier');
        return response()->json(['success', 'Cart Quantity Has Been Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        Cart::remove($id);

        return redirect()->route('cart.index')->with('status', 'Article supprimez');
    }
}
