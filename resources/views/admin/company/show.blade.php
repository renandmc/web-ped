@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Informações empresa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.index') }}">Empresas</a>
                    </li>
                    <li class="breadcrumb-item active">Informações</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        <div class="row">
            <div class="col-md-6 my-auto">
                <div class="row">
                    <div class="col-md-5 text-center">
                        <img src="{{ $company->image_url }}" alt="Foto {{ $company->name }}" class="img-rounded mw-75">
                    </div>
                    <div class="col-md-7">
                        <p class="card-text">
                            <span class="badge badge-{{ $company->active ? 'success' : 'danger' }}">
                                {{ $company->active ? 'Ativa' : 'Inativa' }}
                            </span>
                        </p>
                        <p class="card-text">
                            <span class="font-weight-bold">CNPJ:</span>
                            {{ $company->cnpj }}
                        </p>
                        <p class="card-text">
                            <span class="font-weight-bold">Nome:</span>
                            {{ $company->name }}
                        </p>
                        <p class="card-text">
                            <span class="font-weight-bold">Razão social:</span>
                            {{ $company->corporate_name }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('companies.products.index', [$company]) }}">
                            <x-adminlte-info-box title="Produtos" text="{{ count($company->products) }}"
                                icon="fas fa-lg fa-box-open" icon-theme="primary" />
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#">
                            <x-adminlte-info-box title="Clientes" text="0" icon="fas fa-lg fa-users" icon-theme="primary" />
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#">
                            <x-adminlte-info-box title="Pedidos enviados" text="0" icon="fas fa-lg fa-file-upload"
                                icon-theme="primary" />
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#">
                            <x-adminlte-info-box title="Pedidos recebidos" text="0" icon="fas fa-lg fa-file-download"
                                icon-theme="primary" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-adminlte-card>
@endsection
