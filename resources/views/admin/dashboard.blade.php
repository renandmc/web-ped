@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Painel</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Painel</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-3">
                <x-adminlte-small-box title="{{ count($myCompanies) ?? 0 }}" text="Suas empresas"
                    icon="fas fa-lg fa-building" />
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <x-adminlte-small-box title="{{ count($companies) ?? 0 }}" text="Todas as empresas"
                    icon="fas fa-lg fa-building" />
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <x-adminlte-small-box title="{{ count($products) ?? 0 }}" text="Produtos cadastrados"
                    icon="fas fa-lg fa-box-open" />
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <x-adminlte-small-box title="{{ count($orders) ?? 0 }}" text="Pedidos realizados"
                    icon="fas fa-lg fa-shopping-cart" />
            </div>
        </div>
        <div class="row">
            <div class="col-6">

            </div>
            <div class="col-6">

            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
