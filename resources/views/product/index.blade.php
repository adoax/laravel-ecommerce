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
        @foreach($products as $product)
            <div class="col-md-6">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-3 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary">{{ $product->categories->pluck('name')->implode(', ') }}</strong>
                        <h3 class="mb-0">{{$product->title}}</h3>
                        <div class="mb-1 text-muted">{{$product->created_at->format('d/m/Y')}}</div>
                        <p class="card-text mb-auto">{{$product->excerpt}}.</p>
                        <strong class="card-text mb-auto">{{$product->getPrice()}}</strong>
                        <a href="{{route('produits.show', $product->id)}}" class="stretched-link">Continue reading</a>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <img src="{{$product->image}}" alt="Titre de l'image">
                    </div>
                </div>
            </div>

        @endforeach
    </div>

    {{ $products->appends(request()->input())->links() }}

@endsection

