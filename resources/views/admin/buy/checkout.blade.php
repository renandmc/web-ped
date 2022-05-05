@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Finalizar pedido</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('buy') }}">Comprar</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('buy.products', [$buyer, $seller]) }}">
                            {{ $buyer->name }}
                            <i class="fas fa-fw fa-angle-right"></i>
                            {{ $seller->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Finalizar pedido</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        <div class="row">
            <div class="col">
                <h2>Pedido</h2>
            </div>
            <div class="col-auto my-auto">
                <h5 class="text-center">
                    {{ $buyer->name }}
                    <i class="fas fa-fw fa-angle-right"></i>
                    {{ $seller->name }}
                </h5>
            </div>
        </div>
        <hr>
        @foreach ($items as $item)
            <div class="row mb-2">
                <div class="col-auto mx-4">
                    <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="rounded" height="75">
                </div>
                <div class="col my-auto">
                    <h5 class="text-bold">{{ $item['name'] }}</h5>
                    <h6>
                        R$ {{ number_format($item['price'], 2, ',', '.') }}
                        x {{ $item['quantity'] }}
                    </h6>
                </div>
                <div class="col-auto my-auto">
                    <h6>R$ {{ number_format($item['total_item'], 2, ',', '.') }}</h6>
                </div>
            </div>
        @endforeach
        <hr>
        <div class="row">
            <div class="col text-right">
                <h4 class="text-bold">Total</h4>
                <h5>
                    R$ {{ number_format($total, 2, ',', '.') }}
                </h5>
            </div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-block">Confirmar</button>
            </div>
        </div>
    </x-adminlte-card>
@endsection
