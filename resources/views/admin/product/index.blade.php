@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

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
                <a href="{{ route('companies.products.create', $company) }}" class="btn btn-success" title="Novo">
                    <i class="fas fa-plus"></i>
                    Novo
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @php
                    $heads = ['Status', 'Imagem', 'Nome', 'Tamanho/Un. medida', 'Preço', 'Ações'];
                    $config = [
                        'order' => [[0, 'asc'], [2, 'asc']],
                        'columns' => [null, ['orderable' => false, 'searchable' => false], null, null, null, ['orderable' => false, 'searchable' => false]],
                        'lengthMenu' => [[5, 10, 25], [5, 10, 25]],
                    ];
                @endphp
                <x-adminlte-datatable id="tableProducts" :heads="$heads" :config="$config" hoverable beautify
                    with-buttons>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <span class="badge badge-{{ $product->active ? 'success' : 'danger' }}">
                                    {{ $product->active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td>
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    class="img-fluid rounded">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->measure_unit }}</td>
                            <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary" title="Editar">
                                    <i class="fas fa-fw fa-pen"></i>
                                </a>
                                <x-adminlte-button icon="fas fa-fw fa-trash" theme="danger" title="Excluir"
                                    data-toggle="modal" data-target="#modalDelete" data-id="{{ $product->id }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
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
        $.extend(true, $.fn.dataTable.defaults, {
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/pt_br.json"
            }
        });
    </script>
    <script>
        $('#modalDelete').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let id = button.data('id');
            var modal = $(this);
            modal.find('form').attr('action', '{{ route('products.destroy', '_ID_') }}'.replace('_ID_', id));
        });
    </script>
@endsection
