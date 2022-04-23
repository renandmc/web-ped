@extends('layouts.app')

@section('content')
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('img/logo_icone.png') }}" alt="Logo WEB PED" height="30">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            </ul>
            <ul class="navbar-nav">
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ Auth::user()->name }}</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endauth
                @endif
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="card card-outline card-dark shadow">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <img src="{{ asset('img/logo_horizontal.png') }}" alt="Logo WEB PED" class="bg-dark w-100 mb-2">
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-8">
                        <p class="lead text-center">Para clientes e vendedores que procuram por agilidade, facilidade e redução de custos na tiragem de pedidos...</p>
                    </div>
                    <div class="col-4">
                        <img src="{{ asset('img/estoque.jpg') }}" alt="" class="w-100 rounded">
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-4">
                        <img src="{{ asset('img/pedido.jpg') }}" alt="" class="w-100 rounded">
                    </div>
                    <div class="col-8">
                        <p class="lead">O WEB PED oferece um site com o catálogo dos produtos disponíveis dos vendedores, que simplifica a comercialização dos produtos para seus clientes, ao contrário de outros vendedores, que só realizam tiragem de pedidos pessoalmente, oferecemos um site com a possibilidade da tiragem online.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
