@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Editar produto</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.index') }}">Empresas</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.show', $product->company) }}">Informações</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.products.index', $product->company) }}">Produtos</a>
                    </li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        <p class="text-muted">* campos obrigatórios</p>
        <form action="{{ route('products.update', $product) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-5">
                    <x-adminlte-input name="name" label="Nome *" maxlength="100" value="{{ old('name') ?? $product->name }}" required />
                </div>
                <div class="col-md-5">
                    <x-adminlte-input name="price" label="Preço *" maxlength="20" type="number" min="0.01" step="0.01"
                        value="{{ old('price') ?? $product->price }}" required />
                </div>
                <div class="col-auto">
                    <div class="form-group">
                        <label for="active">Ativo/Inativo</label>
                        <div class="input-group">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-success active">
                                    <input type="radio" name="active" value="1" {{ old('ativo') ?? $product->active ? 'checked' : '' }}>
                                    Ativo
                                </label>
                                <label class="btn btn-outline-danger">
                                    <input type="radio" name="active" value="0" {{ old('ativo') ?? $product->active ? '' : 'checked' }}>
                                    Inativo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <x-adminlte-input name="measure_unit" label="Unidade medida *" maxlength="100"
                        value="{{ old('measure_unit') ?? $product->measure_unit }}" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-textarea name="description" label="Descrição" rows="3">
                        {{ old('description') ?? $product->description }}
                    </x-adminlte-textarea>
                </div>
            </div>
            <div class="float-right">
                <x-adminlte-button type="submit" theme="primary" label="Salvar" />
            </div>
        </form>
    </x-adminlte-card>
@endsection
