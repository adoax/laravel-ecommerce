@extends('layouts.app')

@section('content')
    <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
        <div class="col-md-6 px-0">
            <h1 class="display-4 font-italic">Bienveue sur le Ecomerce de Anthony </h1>
            <p class="lead my-3">Ce site de ecomerce est un faux, il est pour but de mentrainer à créer un Ecormece en
                ligne</p>
            <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Continuer a lire..</a></p>
        </div>
    </div>

    <div class="row mb-2">
            @foreach ($products as $product)
                <div class="col-md-6">
                    <div class="row no-gutters border rounded d-flex align-items-center flex-md-row mb-4 shadow-sm position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <small class="d-inline-block text-info mb-2">

                                <strong class="d-inline-block mb-2 text-primary">{{ $product->categories->pluck('name')->implode(', ') }}</strong>
                            </small>
                            <h5 class="mb-0">{{ $product->title }}</h5>
                            <p class="mb-3 text-muted">{{ $product->subtitle }}</p>
                            <strong class="display-4 mb-4 text-secondary">{{ $product->getPrice() }}</strong>
                            <a href="{{ route('produits.show', $product->id) }}" class="stretched-link btn btn-info"><i class="fa fa-location-arrow" aria-hidden="true"></i> Consulter le produit</a>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="" width="250">
                        </div>
                    </div>
                </div>
            @endforeach
    </div>

    {{ $products->appends(request()->input())->links() }}

@endsection

