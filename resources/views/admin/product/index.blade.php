@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Produtos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.index') }}">Empresas</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.show', $company) }}">Informações</a>
                    </li>
                    <li class="breadcrumb-item active">Produtos</li>
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
                <a href="{{ route('companies.products.create', $company) }}" class="btn btn-primary" title="Novo">
                    <i class="fas fa-plus"></i>
                    Novo
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">

                    <div class="row font-weight-bold">
                        <p class="col my-auto">Imagem</p>
                        <p class="col my-auto">Nome</p>
                        <p class="col my-auto">Tamanho / Un. medida</p>
                        <p class="col my-auto">Preço</p>
                        <p class="col my-auto">Ações</p>
                    </div>
                    <hr>
                    @forelse ($products as $product)
                        <div class="row mb-2">
                            <div class="col my-auto">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    class="img-fluid rounded">
                            </div>
                            <p class="col my-auto font-weight-bold">{{ $product->name }}</p>
                            <p class="col my-auto">{{ $product->size }} {{ $product->measure_unit }}</p>
                            <p class="col my-auto">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                            <div class="col my-auto">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary" title="Editar">
                                    <i class="fas fa-fw fa-pen"></i>
                                    Editar
                                </a>
                                <a href="{{ route('products.destroy', $product) }}" class="btn btn-danger"
                                    title="Excluir">
                                    <i class="fas fa-fw fa-trash"></i>
                                    Excluir
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="row mb-2">
                            Nenhum produto cadastrado
                        </div>
                    @endforelse
                    <div class="row">
                        <div class="col-auto mx-auto">
                            {{ $products->links() }}
                        </div>
                    </div>

            </div>
        </div>
    </x-adminlte-card>
@endsection
