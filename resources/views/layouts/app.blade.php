<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="/icofont/icofont.min.css">
    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')

    @yield('script')

    @yield('extra-meta')
</head>
<body>
<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <a href="{{{route('cart.index')}}}" class="text-muted">Panier <span class="badge badge-pill badge-dark">{{ Cart::count() }}</span></a>
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="/">Ecomerce </a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
               @include('partials.search')
                @guest
                    <a class="btn btn-sm btn-outline-secondary mr-2" href="{{route('login')}}">Se connectez</a>
                    <a class="btn btn-sm btn-outline-secondary" href="{{route('register')}}">S'enregistrer</a>
                @else
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-black-50" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="{{route('profile.command')}}">Voir mes command</a>

                        <a class="dropdown-item" href="#">Gestion de rien *2</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Déconnexion') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>


                    </div>
                @endguest
            </div>
        </div>
    </header>

    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
            @foreach(App\Category::all() as $category)
                <a class="p-2 text-muted" href="{{route('produits.index', ['category' => $category->slug])}}">{{$category->name}}</a>
            @endforeach
        </nav>
    </div>
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session($msg))
                <p class="alert alert-{{ $msg }}">{{ Session($msg) }}</p>
            @endif
        @endforeach
    </div>

    <main class="py-4">
        @yield('content')
    </main>
</div>
<footer class="blog-footer">
    <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.
    </p>
    <p>
        <a href="#">Back to top</a>
    </p>
</footer>
@yield('javascript')

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}"></script>
</body>
</html>
