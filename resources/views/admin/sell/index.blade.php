@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Vender</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.index') }}">Empresas</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.show', $company) }}">{{ $company->name }}</a>
                    </li>
                    <li class="breadcrumb-item active">Vender</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        <div class="row">
            @forelse ($buyers as $buyer)
                <div class="col-md-4">
                    <x-adminlte-card title="{{ $company->name }} ({{ $company->corporate_name ?? '-' }})">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ $company->image_url }}" alt="Foto {{ $company->name }}"
                                    class="img-fluid img-rounded w-100">
                            </div>
                            <div class="col-md-8">
                                <p class="card-text">
                                    <span class="lead">
                                        <span class="badge badge-{{ $company->active ? 'success' : 'danger' }}">
                                            {{ $company->active ? 'Ativa' : 'Inativa' }}
                                        </span>
                                    </span>
                                </p>
                                <p class="card-text">{{ $company->cnpj }}</p>
                            </div>
                        </div>
                    </x-adminlte-card>
                </div>
            @empty
                <div class="col">
                    <x-adminlte-alert>Nenhuma empresa cadastrada</x-adminlte-alert>
                </div>
            @endforelse
        </div>
        <div class="row">
            <div class="col-auto mx-auto">
                {{ $buyers->links() }}
            </div>
        </div>
    </x-adminlte-card>
@endsection
