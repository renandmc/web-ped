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
                    <li class="breadcrumb-item active">Comprar</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        @forelse ($companies as $company)
            @php
                $countSellers = count($company->sellersActive);
            @endphp
            <x-adminlte-card title="{{ $company->name }} ({{ count($company->sellersActive) }} vendedores)" collapsible>
                @if (count($company->sellersActive) > 0)
                    @php
                        $heads = ['Imagem', 'Nome', 'CNPJ', 'Opções'];
                        $config = [
                            'columns' => [
                                ['orderable' => false, 'searchable' => false],
                                null,
                                null,
                                ['orderable' => false, 'searchable' => false]
                            ],
                            'order' => [[1, 'asc']],
                            'lengthMenu' => [[5, 10, 25], [5, 10, 25]],
                        ];
                    @endphp
                    <x-adminlte-datatable id="sellers-{{ $company->id }}" :heads="$heads" :config="$config" beautify>
                        @foreach ($company->sellersActive as $seller)
                            <tr>
                                <td>
                                    <img src="{{ $seller->image_url }}" alt="{{ $seller->name }}"
                                        class="rounded" height="75">
                                </td>
                                <td>{{ $seller->name }}</td>
                                <td>{{ $seller->cnpj }}</td>
                                <td>
                                    <a href="{{ route('buy.products', [$company, $seller]) }}">
                                        Ver produtos
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                @else
                    <p class="card-text">
                        Nenhum vendedor vinculado, <a href="{{ route('partners.create') }}">solicitar vínculos</a>.
                    </p>
                @endif
            </x-adminlte-card>
        @empty
            <p class="card-text">
                Nenhuma empresa cadastrada, <a href="{{ route('companies.create') }}">cadastrar nova</a>.
            </p>
        @endforelse
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
