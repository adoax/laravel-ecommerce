@extends('layouts.app')

@section('content')
    @if(count($products) > 0)
        <p>{{$products->total()}} resultat trouvé</p>
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
                            <a href="{{ route('produits.show', $product->slug) }}" class="stretched-link btn btn-info"><i class="fa fa-location-arrow" aria-hidden="true"></i> Consulter le produit</a>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="" width="250">
                        </div>
                    </div>
                </div>
            @endforeach
    </div>

    {{ $products->appends(request()->input())->links() }}
    @else
        <p>Aucune recherche ne correspond !</p>
    @endif
@endsection
