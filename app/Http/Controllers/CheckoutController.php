<?php

namespace App\Http\Controllers;

use App\Order;
use DateTime;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('hasProduct');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws ApiErrorException
     */
    public function index()
    {
        Stripe::setApiKey('sk_test_w1VTHuP4II7gcPqJjDMH6ehQ00w7PeDuQb');

        $intent = PaymentIntent::create([
            'amount' => round(Cart::total()),
            'currency' => 'eur',
        ]);
        $clientSecret = Arr::get($intent, 'client_secret');

        return view('checkout.index', compact('clientSecret'));
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
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->json()->all();
        $order = new Order();

        $order->payment_intent_id = $data['payementItems']['id'];
        $order->amout = $data['payementItems']['amount'];
        $order->payment_created_at = (new DateTime())
            ->setTimestamp($data['payementItems']['created'])
            ->format('Y-m-d H:i:s');

        $products = [];
        $i = 0;

        foreach (Cart::content() as $product) {
            $products['product_' . $i][] = $product->model->title;
            $products['product_' . $i][] = $product->model->price;
            $products['product_' . $i][] = $product->qty;
            $i++;
        }

        $order->products = serialize($products);
        $order->user_id = 1;
        $order->save();

        if ($data['payementItems']['status'] === 'succeeded') {
            Session::flash('status', 'Votre commande a été traitée avec succès.');
            return response()->json(['status' => 'Payment Intent Succeeded']);
        } else {
            return response()->json(['error' => 'Payment Intent Not Succeeded']);
        }

    }

    /**
     * @return Application|Factory|RedirectResponse|View
     */
    public function thankYou()
    {
        if (Session::has('status')) {
            Cart::destroy();
            return view('checkout.thankyou');

        } else {
            return redirect()->route('produits.index');
        }

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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
