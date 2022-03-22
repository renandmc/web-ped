@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Empresas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Empresas</li>
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
                <a href="{{ route('companies.create') }}" class="btn btn-success" title="Nova">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="row">
            @forelse ($companies as $company)
                <div class="col-md-4">
                    <x-adminlte-card title="{{ $company->name }}">
                        <div class="row">
                            <div class="col-md-4 order-md-last">
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
                                <p class="card-text">
                                    <span class="text-bold">CNPJ:</span> {{ $company->cnpj }}
                                </p>
                                <p class="card-text">
                                    <span class="text-bold">Razão social:</span>
                                    {{ $company->corporate_name ?? '-' }}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-auto float-md-right">
                                <a href="{{ route('companies.show', $company) }}" class="btn btn-default"
                                    title="Informações">
                                    <i class="fas fa-fw fa-info"></i>
                                </a>
                            </div>
                            <div class="col-auto float-md-right">
                                <a href="{{ route('companies.edit', $company) }}" class="btn btn-primary" title="Editar">
                                    <i class="fas fa-fw fa-pen"></i>
                                </a>
                            </div>
                            <div class="col-auto float-md-right">
                                <x-adminlte-button icon="fas fa-fw fa-ban" theme="danger" title="Desativar"
                                    data-toggle="modal" data-target="#modalDelete" data-id="{{ $company->id }}" />
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
                {{ $companies->links() }}
            </div>
        </div>
    </x-adminlte-card>
    <x-adminlte-modal id="modalDelete" title="Desativar empresa">
        <h3>Deseja desativar a empresa?</h3>
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
            modal.find('form').attr('action', '{{ route('companies.destroy', '_ID_') }}'.replace('_ID_', id));
        });
    </script>
@endsection
