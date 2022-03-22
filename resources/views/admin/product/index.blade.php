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
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <div class="row font-weight-bold">
                    <p class="col my-auto">Status</p>
                    <p class="col my-auto">Imagem</p>
                    <p class="col my-auto">Nome</p>
                    <p class="col my-auto">Tamanho / Un. medida</p>
                    <p class="col my-auto">Preço</p>
                    <p class="col my-auto">Ações</p>
                </div>
                <hr>
                @forelse ($products as $product)
                    <div class="row mb-2">
                        <p class="col my-auto lead">
                            <span class="badge badge-{{ $product->active ? 'success' : 'danger' }}">
                                {{ $product->active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </p>
                        <div class="col my-auto">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded">
                        </div>
                        <p class="col my-auto font-weight-bold">{{ $product->name }}</p>
                        <p class="col my-auto">{{ $product->measure_unit }}</p>
                        <p class="col my-auto">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                        <div class="col my-auto">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary" title="Editar">
                                <i class="fas fa-fw fa-pen"></i>
                            </a>
                            <x-adminlte-button icon="fas fa-fw fa-trash" theme="danger" title="Excluir" data-toggle="modal"
                                data-target="#modalDelete" data-id="{{ $product->id }}" />
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
    <x-adminlte-modal id="modalDelete" title="Excluir produto">
        <h3>Deseja excluir o produto?</h3>
        <x-slot name="footerSlot">
            <form action="#" method="post">
                @csrf
                @method('delete')
                <x-adminlte-button type="submit" label="Sim" theme="danger" />
                <x-adminlte-button theme="default" label="Não" data-dismiss="modal" />
            </form>
        </x-slot>
    </x-adminlte-modal>
@endsection

@section('js')
    <script>
        $('#modalDelete').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let id = button.data('id');
            var modal = $(this);
            modal.find('form').attr('action', '{{ route('products.destroy', '_ID_') }}'.replace('_ID_', id));
        });
    </script>
@endsection
