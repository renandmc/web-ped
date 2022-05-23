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
        <form action="{{ route('buy.confirm', [$buyer, $seller]) }}" method="post">
            @csrf
            <div class="row">
                @foreach ($items as $item)
                    <div class="col-12">
                        <div class="row mb-2">
                            <div class="col-auto mx-4">
                                <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="rounded"
                                    height="75">
                            </div>
                            <div class="col my-auto">
                                <h5 class="text-bold">{{ $item['name'] }}</h5>
                            </div>
                            <div class="col my-auto">
                                <h5>
                                    R$ {{ number_format($item['price'], 2, ',', '.') }}
                                    x {{ $item['quantity'] }}
                                </h5>
                            </div>
                            <div class="col-auto my-auto">
                                <h5>R$ {{ number_format($item['total_item'], 2, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="products[{{ $item['id'] }}]" value="{{ $item['quantity'] }}">
                @endforeach
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="row mb-4">
                        <div class="col my-auto">
                            <h4>Endereço para entrega</h4>
                        </div>
                        <div class="col my-auto text-right">
                            <a href="{{ route('companies.show', $buyer) }}" class="btn btn-default">
                                <i class="fas fa-fw fa-plus"></i>
                                Cadastrar novo
                            </a>
                        </div>
                    </div>
                    @if (count($buyer->adresses) > 0)
                        <p class="card-text">
                            <x-adminlte-select name="address">
                                @foreach ($buyer->adresses as $address)
                                    <option value="{{ $address->id }}">{{ $address->address }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </p>
                    @else
                        <p class="card-text">
                            Nenhum endereço cadastrado, cadastre um endereço para finalizar o pedido.
                        </p>
                    @endif
                </div>
                <div class="col text-right">
                    <h4>Total</h4>
                    <h5>
                        R$ {{ number_format($total, 2, ',', '.') }}
                    </h5>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <a href="{{ route('buy.products', [$buyer, $seller]) }}" class="btn btn-default">
                        <i class="fas fa-fw fa-arrow-left"></i>
                        Pedir mais itens
                    </a>
                </div>
                <div class="col-auto">
                    @if (count($buyer->adresses) > 0)
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-fw fa-check"></i>
                            Confirmar pedido
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </x-adminlte-card>
@endsection
