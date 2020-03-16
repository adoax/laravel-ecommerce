@extends('layouts.app')


@section('extra-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')

    <div class="px-4 px-lg-0 bg-cart">
        <!-- End -->

        @if(Cart::count() >= 1)
            <div class="pb-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

                            <!-- Shopping cart table -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="p-2 px-3 text-uppercase">Produit</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Prix</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Quantité</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Supprimer</div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($carts as $cart)

                                        <tr>
                                            <th scope="row" class="border-0">
                                                <div class="p-2">
                                                    <img
                                                        src="https://res.cloudinary.com/mhmd/image/upload/v1556670479/product-1_zrifhn.jpg"
                                                        alt="" width="70" class="img-fluid rounded shadow-sm">
                                                    <div class="ml-3 d-inline-block align-middle">
                                                        <h5 class="mb-0"><a href="#"
                                                                            class="text-dark d-inline-block align-middle">{{$cart->model->title}}</a>
                                                        </h5><span
                                                            class="text-muted font-weight-normal font-italic d-block">Category: Watches</span>
                                                    </div>
                                                </div>
                                            </th>
                                            <td class="border-0 align-middle">
                                                <strong>{{getPrice($cart->subtotal())}}</strong></td>
                                            <td class="border-0 align-middle">
                                                <select name="qty" id="qty" class="custom-select"
                                                        data-stock="{{$cart->model->stocks}}"
                                                        data-id="{{ $cart->rowId  }}">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <option
                                                            value="{{$i}}" {{ $i == $cart->qty ? 'selected' : '' }}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                @error('qty') <small id="qty"
                                                                     class="form-text text-muted">{{ $message }}</small> @enderror
                                            </td>
                                            <td class="border-0 align-middle">

                                                <form action="{{route('cart.destroy', $cart->rowId)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"><i
                                                            class="icofont-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- End -->
                        </div>
                    </div>

                    <div class="row py-5 p-4 bg-white rounded shadow-sm">
                        <div class="col-lg-6">
                            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Code coupon
                            </div>
                            @if (!request()->session()->has('coupon'))
                                <div class="p-4">
                                    <p class="font-italic mb-4">Si vous avez un code coupon, veuillez le saisir dans la
                                        case
                                        ci-dessous</p>
                                    <form action="{{route('cart.store.coupon')}}" method="post">
                                        <div class="input-group mb-4 border rounded-pill p-2">

                                            @csrf
                                            <input type="text" placeholder="Code coupon"
                                                   aria-describedby="button-addon3"
                                                   name="coupon"
                                                   class="form-control border-0">
                                            <div class="input-group-append border-0">
                                                <button id="button-addon3" type="submit"
                                                        class="btn btn-dark px-4 rounded-pill">
                                                    <i
                                                        class="fa fa-gift mr-2"></i>Validée
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <p>Un coupon est deja appliquer</p>
                            @endif
                            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">INSTRUCTIONS
                                POUR LE VENDEUR
                            </div>
                            <div class="p-4">
                                <p class="font-italic mb-4">Si vous avez des informations pour le vendeur, vous pouvez
                                    les laisser dans la case ci-dessous</p>
                                <textarea name="" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Résumé de la
                                commande
                            </div>
                            <div class="p-4">
                                <p class="font-italic mb-4">Les frais d'expédition et les frais supplémentaires sont
                                    calculés sur la base des valeurs que vous avez saisies.</p>
                                <ul class="list-unstyled mb-4">
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                            class="text-muted">Sous-total
                                        </strong><strong>{{getPrice(Cart::subtotal())}}</strong></li>
                                    @if(request()->session()->has('coupon'))

                                        <li class="d-flex justify-content-between py-3 border-bottom">
                                            <strong
                                                class="text-muted">Coupon
                                                "{{ request()->session()->get('coupon')['code'] }}"
                                                <form action="{{ route('cart.destroy.coupon') }}" method="POST"
                                                      class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-outline-danger btn-sm icofont-trash"></button>
                                                </form>
                                            </strong>
                                            <strong>{{ getPrice(request()->session()->get('coupon')['remise'])  }}</strong>
                                        </li>
                                        <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                                class="text-muted">Nouveau
                                                sous-total</strong><strong>{{ getPrice(getSubTotalCoupon()) }}</strong>
                                        </li>
                                        <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                                class="text-muted">Taxe:
                                                20%</strong><strong>{{ getPrice(getTaxCoupon())}}</strong>
                                        </li>
                                        <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                                class="text-muted">Total</strong>
                                            <h5 class="font-weight-bold">{{ getPrice(getTotalCoupon()) }}</h5>
                                        </li>
                                    @else
                                        <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                                class="text-muted">Taxe:
                                                20%</strong><strong>{{getPrice(Cart::tax())}}</strong>
                                        </li>
                                        <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                                class="text-muted">Total</strong>
                                            <h5 class="font-weight-bold">{{getPrice(Cart::total())}}</h5>
                                        </li>
                                    @endif

                                </ul>
                                <a href="{{route('checkout.index')}}" class="btn btn-dark rounded-pill py-2 btn-block">Procéder
                                    au paiement</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @else
            <p class="text-center pt-4">Panier vide !</p>
        @endif
    </div>


@endsection


@section('javascript')

    <script>
        var qty = document.querySelectorAll('#qty');
        Array.from(qty).forEach((element) => {
            element.addEventListener('change', function () {
                var rowId = element.getAttribute('data-id');
                var stock = element.getAttribute('data-stock');
                var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch(`/panier/${rowId}`,
                    {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        method: 'PATCH',
                        body: JSON.stringify({
                            qty: this.value,
                            stock: stock
                        })
                    }).then((data) => {
                    console.log(data);
                    location.reload();
                }).catch((error) => {
                    console.log(error);
                });
            });
        });
    </script>

@endsection
