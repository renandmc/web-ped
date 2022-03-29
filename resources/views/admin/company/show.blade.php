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
        <div class="row">
            <div class="col-md-6 my-auto">
                <div class="row">
                    <div class="col-md-5 text-center">
                        <img src="{{ $company->image_url }}" alt="Foto {{ $company->name }}" class="img-rounded mw-75">
                    </div>
                    <div class="col-md-7">
                        <p class="card-text">
                            <span class="lead">
                                <span class="badge badge-{{ $company->active ? 'success' : 'danger' }}">
                                    {{ $company->active ? 'Ativa' : 'Inativa' }}
                                </span>
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
                        <a href="{{ route('buy.index', [$company]) }}">
                            <x-adminlte-info-box title="Comprar" icon="fas fa-lg fa-shopping-cart" icon-theme="primary" />
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('sell.index', [$company]) }}">
                            <x-adminlte-info-box title="Vender" icon="fas fa-lg fa-box-open" icon-theme="primary" />
                        </a>
                    </div>
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
        <hr>
        <div class="row mb-2">
            <div class="col">
                <h3>Endereços</h3>
            </div>
            <div class="col-auto float-md-right">
                <x-adminlte-button icon="fas fa-fw fa-plus" theme="primary" title="Novo" data-toggle="modal"
                    data-target="#modalAddress" />
            </div>
        </div>
        <div class="row">
            @forelse ($company->adresses as $address)
                <div class="col-3">
                    <x-adminlte-card>
                        <p class="card-text">
                            <span class="text-bold">CEP:</span>
                            {{ $address->cep }}
                        </p>
                        <p class="card-text">
                            <span class="text-bold">Logradouro:</span>
                            {{ $address->street }} {{ $address->number }}
                        </p>
                        <p class="card-text">
                            <span class="text-bold">Bairro:</span>
                            {{ $address->neighborhood }}
                        </p>
                        <p class="card-text">
                            <span class="text-bold">Cidade - Estado (UF):</span>
                            {{ $address->city }} - {{ $address->state }}
                        </p>
                        <p class="card-text">
                            <span class="text-bold">Observações:</span>
                            {{ $address->notes }}
                        </p>
                        <div class="float-right">
                            <x-adminlte-button icon="fas fa-fw fa-trash" theme="danger" title="Excluir" data-toggle="modal"
                                data-target="#modalDelete" data-id="{{ $address->id }}"
                                data-company="{{ $company->id }}" />
                        </div>
                    </x-adminlte-card>
                </div>
            @empty
                <div class="col">
                    <p class="text-center">
                        Nenhum endereço cadastrado
                    </p>
                </div>
            @endforelse
        </div>
    </x-adminlte-card>
    <x-adminlte-modal id="modalAddress" title="Novo endereço">
        <form action="{{ route('companies.adresses.store', [$company]) }}" method="post">
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
    <x-adminlte-modal id="modalDelete" title="Excluir endereço">
        <h3>Deseja excluir o endereço?</h3>
        <x-slot name="footerSlot">
            <form action="#" method="post">
                @csrf
                @method('delete')
                <input type="hidden" name="company" value="">
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
            $('#modalDelete').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let id = button.data('id');
                let company = button.data('company');
                var modal = $(this);
                modal.find('input[name="company"]').val(company);
                modal.find('form').attr('action',
                    '{{ route('adresses.destroy', '_ID_') }}'
                    .replace('_ID_', id)
                    .replace('_company_', company));
            });
        });
    </script>
@endsection
