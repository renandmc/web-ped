@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Produtos ({{ $seller->name }})</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('buy') }}">Comprar</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ $buyer->name }}
                        <i class="fas fa-fw fa-angle-right"></i>
                        {{ $seller->name }}
                    </li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        <div class="row">
            @if (count($seller->products) > 0)
                <div class="col-12 col-lg-7">
                    @php
                        $heads = ['Imagem', 'Nome', 'Preço', 'Opções'];
                        $config = [
                            'order' => [[1, 'asc']],
                            'columns' => [['orderable' => false, 'searchable' => false], null, null, ['orderable' => false, 'searchable' => false]],
                            'lengthMenu' => [[5, 10, 15], [5, 10, 15]],
                        ];
                    @endphp
                    <x-adminlte-datatable id="tableProducts" :heads="$heads" :config="$config" beautify>
                        @foreach ($seller->products as $product)
                            <tr>
                                <td>
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                        class="rounded" height="75">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('buy.add', [$product, 'buyer' => $buyer->id, 'seller' => $seller->id]) }}"
                                        class="btn btn-primary">
                                        <i class="fas fa-fw fa-shopping-cart"></i>
                                        Comprar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
                <div class="col-12 col-lg-5">
                    <x-adminlte-card title="Pedido">
                        <p class="card-text">
                            {{ $buyer->name }}
                            <i class="fas fa-fw fa-angle-right"></i>
                            {{ $seller->name }}
                        </p>
                        <hr>
                        @php $total = 0; @endphp
                        @if (session("cart-$buyer->id-$seller->id"))
                            @foreach (session("cart-$buyer->id-$seller->id") as $id => $details)
                                @php $total += $details['price'] * $details['quantity']; @endphp
                                <div class="row mb-2">
                                    <div class="col-auto">
                                        <img src="{{ $details['image_url'] }}" alt="{{ $details['name'] }}"
                                            height="75" class="rounded">
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="card-text">
                                                    <b>{{ $details['name'] }}</b>
                                                    <br>
                                                    R$ {{ number_format($details['price'], 2, ',', '.') }}
                                                    <br>
                                                    x {{ $details['quantity'] }}
                                                </p>
                                            </div>
                                            <div class="col-6 my-auto">
                                                <p class="card-text">
                                                    R$
                                                    {{ number_format($details['quantity'] * $details['price'], 2, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto my-auto">
                                        <button class="btn btn-sm btn-danger removeCart" data-id="{{ $id }}"
                                            data-buyer="{{ $buyer->id }}" data-seller="{{ $seller->id }}">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            <h5>Total</h5>
                            <p class="card-text">R$ {{ number_format($total, 2, ',', '.') }}</p>
                            <button class="btn btn-primary btn-block">Finalizar pedido</button>
                        @else
                            <p class="card-text">Nenhum produto adicionado</p>
                        @endif
                    </x-adminlte-card>
                </div>
            @else
                <div class="col-12">
                    <p class="card-text">Nenhum produto cadastrado</p>
                </div>
            @endif
        </div>
    </x-adminlte-card>
@endsection

@section('js')
    <script>
        $.extend(true, $.fn.dataTable.defaults, {
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/pt_br.json"
            }
        });
        $(".removeCart").click(function(e) {
            e.preventDefault();
            let el = $(this);
            let id = el.attr("data-id");
            let buyer = el.attr("data-buyer");
            let seller = el.attr("data-seller");
            if (confirm("Tem certeza?")) {
                $.ajax({
                    url: "{{ route('buy.remove') }}",
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id,
                        buyer,
                        seller
                    },
                    success: function(res) {
                        window.location.reload();
                    }
                });
            }
        })
    </script>
@endsection
