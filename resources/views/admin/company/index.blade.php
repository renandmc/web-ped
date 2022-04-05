@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Empresas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Empresas</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        <div class="row mb-4">
            <div class="col"></div>
            <div class="col-auto float-md-right">
                <a href="{{ route('companies.create') }}" class="btn btn-success" title="Nova">
                    <i class="fas fa-plus"></i>
                    Nova
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @php
                    $heads = ['Status', 'Nome', 'Razão social', 'CNPJ', 'Opções'];
                    $config = [
                        'order' => [[0, 'asc'], [1, 'asc']],
                        'columns' => [null, null, null, null, ['orderable' => false, 'searchable' => false]],
                        'lengthMenu' => [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
                    ];
                @endphp
                <x-adminlte-datatable id="tableCompanies" :heads="$heads" :config="$config" hoverable beautify with-buttons>
                    @forelse ($companies as $company)
                        <tr>
                            <td>
                                <span class="lead">
                                    <span class="badge badge-{{ $company->active ? 'success' : 'danger' }}">
                                        {{ $company->active ? 'Ativa' : 'Inativa' }}
                                    </span>
                                </span>
                            </td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->corporate_name }}</td>
                            <td>{{ $company->cnpj }}</td>
                            <td>
                                <a href="{{ route('buy', $company) }}" class="btn btn-primary" title="Comprar">
                                    <i class="fas fa-fw fa-shopping-cart"></i>
                                    Comprar
                                </a>
                                <a href="{{ route('sell', $company) }}" class="btn btn-primary" title="Vender">
                                    <i class="fas fa-fw fa-store-alt"></i>
                                    Vender
                                </a>
                                <a href="{{ route('companies.show', $company) }}" class="btn btn-default"
                                    title="Informações">
                                    <i class="fas fa-fw fa-info"></i>
                                    Info
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Nenhuma empresa encontrada</td>
                        </tr>
                    @endforelse
                </x-adminlte-datatable>
            </div>
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
