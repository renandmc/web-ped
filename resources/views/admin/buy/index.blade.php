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
                @foreach ($company->sellersActive as $seller)
                    <div class="col-4">
                        <x-adminlte-card>
                            <div class="row">
                                <div class="col-8">
                                    <h6>{{ $seller->name }}</h6>
                                    <p class="card-text">{{ $seller->cnpj }}</p>
                                </div>
                                <div class="col-4">
                                    <a href="#" class="btn btn-block btn-default">Produtos</a>
                                </div>
                            </div>
                        </x-adminlte-card>
                    </div>
                @endforeach
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
