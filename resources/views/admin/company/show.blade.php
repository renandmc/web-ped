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
        <div class="row mb-4">
            <div class="col"></div>
            <div class="col-auto float-md-right">
                <a href="{{ route('companies.edit', $company) }}" class="btn btn-primary">
                    <i class="fas fa-fw fa-pencil-alt"></i>
                    Editar
                </a>
            </div>
            <div class="col-auto float-md-right">
                <form action="{{ route('companies.destroy', $company) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-fw fa-ban"></i>
                        Desativar
                    </button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ $company->image_url }}" alt="Foto {{ $company->name }}" class="img-rounded mw-75">
                    </div>
                    <div class="col-md-9">
                        <p class="card-text">{{ $company->name }}</p>
                        <p class="card-text">{{ $company->cnpj }}</p>
                        <p class="card-text">{{ $company->corporate_name }}</p>
                        <p class="card-text">
                            <span class="badge badge-{{ $company->active ? 'success' : 'danger' }}">
                                {{ $company->active ? 'Ativa' : 'Inativa' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 my-auto">
                <div class="row mb-2">

                </div>
                <div class="row">

                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                Relatório
            </div>
            <div class="col">
                produtos
            </div>
            <div class="col">
                pedidos enviados
            </div>
            <div class="col">
                pedidos recebidos
            </div>
        </div>
    </x-adminlte-card>
@endsection
