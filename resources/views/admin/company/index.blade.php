@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Minhas empresas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Minhas empresas</li>
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
                    $heads = ['Status', 'Nome', 'CNPJ', 'Opções'];
                    $config = [
                        'order' => [[0, 'asc'], [1, 'asc']],
                        'columns' => [null, null, null, ['orderable' => false, 'searchable' => false]],
                        'lengthMenu' => [[5, 10, 25], [5, 10, 25]],
                    ];
                @endphp
                <x-adminlte-datatable id="tableCompanies" :heads="$heads" :config="$config" hoverable beautify>
                    @forelse ($companies as $company)
                        <tr>
                            <td>
                                <span class="badge badge-{{ $company->active ? 'success' : 'danger' }}">
                                    {{ $company->active ? 'Ativa' : 'Inativa' }}
                                </span>
                            </td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->cnpj }}</td>
                            <td>
                                <a href="{{ route('companies.products.index', $company) }}" class="btn btn-primary">
                                    <i class="fas fa-fw fa-box-open"></i>
                                    Produtos
                                    &nbsp;
                                    <span class="badge badge-light">{{ count($company->products) }}</span>
                                </a>
                                <a href="{{ route('companies.edit', $company) }}" class="btn btn-primary" title="Editar">
                                    <i class="fas fa-fw fa-pen"></i>
                                    Editar
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
                            <td colspan="5">Nenhuma empresa cadastrada</td>
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
