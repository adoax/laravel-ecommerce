<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
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

        if (request()->session()->has('coupon')) {
            $total = getTotalCoupon();
        } else {
            $total = Cart::total();
        }


        $intent = PaymentIntent::create([
            'amount' => round($total),
            'currency' => 'eur',
        ]);

        $clientSecret = Arr::get($intent, 'client_secret');

        return view('checkout.index', compact('clientSecret', 'total'));
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
        if ($this->checkIfNotAvailable()) {
            Session::flash('warning', 'Un produit dans votre panier n\'est plus disponible');
            return response()->json(['success' => false], 400);
        }

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
        $order->user_id = Auth()->id() ?? '';
        $order->save();

        if ($data['payementItems']['status'] === 'succeeded') {
            Session::flash('success', 'Votre commande a été traitée avec succès.');
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
        if (Session::has('success')) {
            $this->updateStock();
            Cart::destroy();
            return view('checkout.thankyou');

        } else {
            return redirect()->route('produits.index');
        }

    }

    /**
     * Permet de verifier si il y à les stock necessaire à l'achat
     */
    private function checkIfNotAvailable()
    {
        foreach(Cart::content() as $item) {
            $product = Product::find($item->model->id);

            if ($product->stocks < $item->qty) {
                return true;
            }
        }
        return false;
    }

    /**
     * Permet de mettre a jour le stock des objet à l'achat de celui-ci
     */
    private function updateStock()
    {
        foreach(Cart::content() as $item) {
            $product = Product::find($item->model->id);
            $product->update(['stocks' => $product->stocks - $item->qty]);
        }
    }
}
