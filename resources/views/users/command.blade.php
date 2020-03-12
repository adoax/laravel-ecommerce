@extends('layouts.app')

@section('content')
    @foreach($orders as $order)
        <div class="card">
            <div class="card-header">
                Commande passé le {{ \Carbon\Carbon::parse($order->payment_created_at)->format('d/m/Y')   }}, d'un montant de {{ getPrice($order->amout) }}
            </div>
            <div class="card-body">
                @foreach(unserialize($order->products) as $product)
                    <div>Nom du Produit: {{ $product[0] }}</div>
                    <div>Prix: {{ getPrice($product[1] )}}</div>
                    <div>Quantité: {{ $product[2] }}</div>
                    <hr>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
