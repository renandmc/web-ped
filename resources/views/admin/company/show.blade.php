@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Informações</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.index') }}">Empresas</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $company->name }}</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('plugins.InputMask', true)

@section('content')
    <x-adminlte-card>
        <div class="row mb-4">
            <div class="col my-auto">
                <div class="row">
                    <div class="col-4 text-center">
                        <img src="{{ $company->image_url }}" alt="Foto {{ $company->name }}" class="img-rounded mw-75">
                    </div>
                    <div class="col">
                        <p class="card-text lead">
                            <span class="font-weight-bold">
                                {{ $company->name }} ({{ $company->corporate_name }})
                            </span>
                            <span class="badge badge-{{ $company->active ? 'success' : 'danger' }}">
                                {{ $company->active ? 'Ativa' : 'Inativa' }}
                            </span>
                        </p>
                        <p class="card-text">
                            CNPJ
                            {{ $company->cnpj }}
                        </p>
                        <p class="card-text font-weight-light">
                            Cadastrado em {{ $company->created_at->isoFormat('LL')}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <a href="{{ route('companies.edit', $company) }}" class="btn btn-primary btn-block" title="Editar">
                    <i class="fas fa-fw fa-pen"></i>
                    Editar
                </a>
                <x-adminlte-button class="btn-block" theme="danger" icon="fas fa-fw fa-ban" title="Desativar"
                    label="Desativar" data-toggle="modal" data-target="#modalDelCompany" data-id="{{ $company->id }}" />
                <a href="{{ route('companies.products.index', $company) }}" class="btn btn-primary btn-block">
                    <i class="fas fa-fw fa-box-open"></i>
                    Produtos
                    &nbsp;
                    <span class="badge badge-light">{{ count($company->products) }}</span>
                </a>
            </div>
        </div>
        <hr>
        <div class="row mb-2">
            <div class="col-auto">
                <h3>Endereços</h3>
            </div>
            <div class="col-auto">
                <x-adminlte-button icon="fas fa-fw fa-plus" theme="primary" title="Novo" data-toggle="modal"
                    data-target="#modalAddress" label="Novo" />
            </div>
        </div>
        @forelse ($company->adresses as $address)
            <div class="row">
                <div class="col-12">
                    <x-adminlte-card>
                        <div class="row">
                            <div class="col my-auto">
                                <p class="card-text">
                                    <span class="font-weight-bold">
                                        {{ $address->street }}, {{ $address->number }} -
                                        {{ $address->neighborhood }}
                                    </span>
                                    <br>
                                    {{ $address->city }} - {{ $address->state }}
                                    <br>
                                    {{ $address->cep }}
                                </p>
                                @if ($address->notes != '')
                                    <p class="card-text font-weight-light">
                                        {{ $address->notes }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-auto float-right my-auto">
                                <x-adminlte-button icon="fas fa-fw fa-trash" theme="danger" title="Excluir"
                                    data-toggle="modal" data-target="#modalDelAddress" data-id="{{ $address->id }}"
                                    label="Excluir" />
                            </div>
                        </div>
                    </x-adminlte-card>
                </div>
            </div>
        @empty
            <div class="col">
                <p class="text-center">
                    Nenhum endereço cadastrado
                </p>
            </div>
        @endforelse
    </x-adminlte-card>
    <x-adminlte-modal id="modalDelCompany" title="Desativar empresa">
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
    <x-adminlte-modal id="modalAddress" title="Novo endereço">
        <form action="{{ route('companies.adresses.store', $company) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-6">
                    <x-adminlte-input name="cep" label="CEP *" maxlength="9" data-inputmask="'mask': '99999-999'" data-mask
                        inputmode="numeric" value="{{ old('cep') }}" required />
                </div>
                <div class="col-6">
                    <x-adminlte-input name="street" label="Logradouro *" maxlength="200" value="{{ old('street') }}"
                        required />
                </div>
                <div class="col-6">
                    <x-adminlte-input name="number" label="Número" maxlength="20" value="{{ old('number') }}" />
                </div>
                <div class="col-6">
                    <x-adminlte-input name="neighborhood" label="Bairro *" maxlength="200"
                        value="{{ old('neighborhood') }}" required />
                </div>
                <div class="col-6">
                    <x-adminlte-input name="city" label="Cidade *" maxlength="200" value="{{ old('city') }}" required />
                </div>
                <div class="col-6">
                    <x-adminlte-input name="state" label="Estado (UF) *" maxlength="2" value="{{ old('state') }}"
                        required />
                </div>
                <div class="col-12">
                    <x-adminlte-textarea name="notes" label="Observações" rows="3">
                        {{ old('notes') }}
                    </x-adminlte-textarea>
                </div>
                <div class="col"></div>
                <div class="col-auto float-right">
                    <x-adminlte-button theme="primary" label="Salvar" type="submit" />
                    <x-adminlte-button theme="default" label="Cancelar" data-dismiss="modal" />
                </div>
            </div>
            <x-slot name="footerSlot"></x-slot>
        </form>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalDelAddress" title="Excluir endereço">
        <h3>Deseja excluir o endereço?</h3>
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
        $(document).ready(function() {
            $('[data-mask]').inputmask();
            $('input[name="cep"]').focusout(function() {
                const cep = $(this).val().replace('.', '').replace('-', '');
                if (cep != '') {
                    $.ajax({
                        method: 'get',
                        url: 'https://brasilapi.com.br/api/cep/v1/' + cep,
                        dataType: 'json',
                        success: function(data) {
                            $('input[name="street"]').val(data.street);
                            $('input[name="neighborhood"]').val(data.neighborhood);
                            $('input[name="city"]').val(data.city);
                            $('input[name="state"]').val(data.state);
                        }
                    });
                }
            });
            $('#modalDelAddress').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let id = button.data('id');
                var modal = $(this);
                modal.find('form').attr('action', '{{ route('adresses.destroy', '_ID_') }}'.replace(
                    '_ID_', id));
            });
            $('#modalDelCompany').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let id = button.data('id');
                var modal = $(this);
                modal.find('form').attr('action', '{{ route('companies.destroy', '_ID_') }}'.replace(
                    '_ID_', id));
            });
        });
    </script>
@endsection
