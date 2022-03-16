@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Novo produto</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.index') }}">Empresas</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.show', $company) }}">Informações</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.products.index', $company) }}">Produtos</a>
                    </li>
                    <li class="breadcrumb-item active">Novo</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        <p class="text-muted">* campos obrigatórios</p>
        <form action="{{ route('companies.products.store', $company) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <x-adminlte-input name="name" label="Nome *" maxlength="100" value="{{ old('name') }}" required />
                </div>
                <div class="col-md-5">
                    <x-adminlte-input name="price" label="Preço *" maxlength="20" type="number" min="0.01" step="0.01"
                        value="{{ old('price') }}" required />
                </div>
                <div class="col-auto">
                    <div class="form-group">
                        <label for="active">Ativo/Inativo</label>
                        <div class="input-group">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-success active">
                                    <input type="radio" name="active" value="1" {{ old('ativo', '1') ? 'checked' : '' }}>
                                    Ativo
                                </label>
                                <label class="btn btn-outline-danger">
                                    <input type="radio" name="active" value="0" {{ old('ativo', '1') ? '' : 'checked' }}>
                                    Inativo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <x-adminlte-input name="size" label="Tamanho *" type="number" value="{{ old('size') }}" required />
                </div>
                <div class="col-md-3">
                    <x-adminlte-input name="measure_unit" label="Unidade medida *" maxlength="100"
                        value="{{ old('measure_unit') }}" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-textarea name="description" label="Descrição" rows="3">
                        {{ old('description') }}
                    </x-adminlte-textarea>
                </div>
            </div>
            <div class="float-right">
                <x-adminlte-button type="submit" theme="primary" label="Salvar" />
            </div>
        </form>
    </x-adminlte-card>
@endsection
