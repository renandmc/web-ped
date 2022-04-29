@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Comprar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.index') }}">Empresas</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.show', $company) }}">{{ $company->name }}</a>
                    </li>
                    <li class="breadcrumb-item active">Comprar</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        <h5>Vendedores vinculados</h5>
        <hr>
        <div class="row">
            @if (count($company->sellersActive) > 0)
                <div class="col-8">
                    @foreach ($company->sellersActive as $seller)
                        <x-adminlte-card title="{{ $seller->name }}" collapsible="collapsed">
                            @php
                                $heads = ['Imagem', 'Nome', 'Un. medida', 'Preço', 'Opções'];
                                $config = [
                                    'order' => [[0, 'asc'], [1, 'asc']],
                                    'columns' => [null, null, null, null, ['orderable' => false, 'searchable' => false]],
                                    'lengthMenu' => [[3, 5, 10], [3, 5, 10]],
                                ];
                            @endphp
                            <x-adminlte-datatable id="products-{{ $seller->id }}" :heads="$heads" :config="$config"
                                hoverable beautify>
                                @forelse ($seller->products as $product)
                                    <tr>
                                        <td>
                                            <img src="{{ $product->image_url }}" alt="" class="img-fluid rounded">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->measure_unit }}</td>
                                        <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                        <td><a href="#">Adicionar</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Nenhum produto</td>
                                    </tr>
                                @endforelse
                            </x-adminlte-datatable>
                        </x-adminlte-card>
                    @endforeach
                </div>
                <div class="col-4">
                    <x-adminlte-card>
                        <h5>Pedido</h5>
                        <hr>
                        Itens
                    </x-adminlte-card>
                </div>
            @else
                <div class="col-12">
                    <p class="card-text">Nenhum vendedor vinculado</p>
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
    </script>
@endsection
