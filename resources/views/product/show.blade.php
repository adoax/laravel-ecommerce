@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div
            class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col p-3 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary">La CATEGORY</strong>
                <h3 class="mb-0">{{$product->title}}</h3>
                <div class="mb-1 text-muted">{{$product->created_at->format('d/m/Y')}}</div>
                <p class="card-text mb-auto">{{$product->description}}.</p>
                <strong class="card-text mb-auto">{{$product->getPrice()}}</strong>
                <form action="">
                    <button type="submit" class="btn btn-dark">Ajouter au panier</button>
                </form>
            </div>
            <div class="col-auto d-none d-lg-block">
                <img src="{{$product->image}}" alt="Titre de l'image">
            </div>
        </div>
    </div>
@endsection
