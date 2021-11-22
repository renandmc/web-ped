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
                        <img src="https://pixabay.com/get/g94066559fb006b06ecfc1b6c80bbd1d5de642083bd3bee82b54bb1c44340b582e3ee14cf768a99c1c85dd353e08ab1b1b59ed1abdad60ae634e4d0385a64a59381450bf446342ee16a52345cd837e306_1920.jpg" alt="" class="w-100 rounded">
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-4">
                        <img src="https://pixabay.com/get/g277b6556a0789c3a14c1a380118dc392f5b05ed4d977224175615ac927a5a9fdd6dfef118f936db1ea5b5c129654812a8d029d62441858ef44a1d8022cfdb23fb67b3113fa011a2353c13c8f49c713af_1920.jpg" alt="" class="w-100 rounded">
                    </div>
                    <div class="col-8">
                        <p class="lead">O WEB PED oferece um site com o catálogo dos produtos disponíveis dos vendedores, que simplifica a comercialização dos produtos para seus clientes, o contrário de outros vendedores, que só realizam tiragem de pedidos pessoalmente, oferecemos um site com a possibilidade da tiragem online.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
