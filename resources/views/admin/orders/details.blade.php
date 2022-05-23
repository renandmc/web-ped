@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Detalhes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url()->previous() }}">
                            {{ url()->previous() == route('orders.sent') ? 'Pedidos enviados' : 'Pedidos recebidos' }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Detalhes</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        <div class="row mb-3">
            <div class="col-12">
                <h4>
                    <i class="fas fa-fw fa-receipt"></i>
                    Pedido #{{ $order->id }}
                    <small class="float-right">Data/hora: {{ $order->created_at->format('d/m/Y H:i') }}</small>
                </h4>
            </div>
        </div>
        <div class="row invoice-info mb-3">
            <div class="col-sm-4 invoice-col">
                <b>Vendedor</b>
                <h5>{{ $order->seller->name }}</h5>
            </div>
            <div class="col-sm-4 invoice-col">
                <b>Comprador</b>
                <h5>{{ $order->buyer->name }}</h5>
            </div>
            <div class="col-sm-4 invoice-col">
                <b>Endereço entrega</b>
                <br>
                {{ $order->address->street }}, {{ $order->address->number }} - {{ $order->address->neighborhood }}
                <br>
                {{ $order->address->city }} - {{ $order->address->state }} - {{ $order->address->cep }}
                <br>
                {{ $order->address->notes }}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Unid.</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Preço</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->product->measure_unit }}</td>
                                <td>{{ Str::limit($item->product->description, 45) }}</td>
                                <td>R$ {{ number_format($item->product->price, 2, ',', '.') }}</td>
                                <td>x {{ $item->quantity }}</td>
                                <td>R$ {{ number_format($item->total_item, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <p class="card-text">
                    <b>Observações</b>
                    <br>
                    {{ $order->notes ?? "Sem observações" }}
                </p>
            </div>
            <div class="col-6 text-right">
                <h5>
                    <b>Total</b>
                    <br>
                    R$ {{ number_format($order->total, 2, ',', '.') }}
                </h5>
            </div>
        </div>
        <div class="row no-print">
            <div class="col-12">
                <a href="#" class="btn btn-default float-right" onclick="window.print()">
                    <i class="fas fa-fw fa-print"></i>
                    Imprimir
                </a>
            </div>
        </div>
    </x-adminlte-card>
@endsection
