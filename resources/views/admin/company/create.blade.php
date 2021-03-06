@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Nova</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.index') }}">Empresas</a>
                    </li>
                    <li class="breadcrumb-item active">Nova</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('plugins.InputMask', true)

@section('content')
    <x-adminlte-card>
        <p class="text-muted">* campos obrigatórios</p>
        <form action="{{ route('companies.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-input name="cnpj" label="CNPJ *" maxlength="18"
                        data-inputmask="'mask': '99.999.999/9999-99'" data-mask inputmode="numeric"
                        value="{{ old('cnpj') }}" required />
                </div>
                <div class="col-md">
                    <x-adminlte-input name="name" label="Nome *" maxlength="100" value="{{ old('name') }}" required />
                </div>
                <div class="col-md">
                    <x-adminlte-input name="corporate_name" label="Razão social *" maxlength="100"
                        value="{{ old('corporate_name') }}" required />
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
            </div>
            <div class="float-right">
                <x-adminlte-button type="submit" theme="primary" label="Salvar" />
            </div>
        </form>
    </x-adminlte-card>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('[data-mask]').inputmask();
            $('input[name="cnpj"]').focusout(function() {
                const cnpj = $(this).val().replace('.', '').replace('/', '').replace('-', '');
                if (cnpj != '') {
                    $.ajax({
                        method: 'get',
                        url: 'https://brasilapi.com.br/api/cnpj/v1/' + cnpj,
                        dataType: 'json',
                        success: function(data) {
                            if (data.nome_fantasia != '') {
                                $('input[name="name"]').val(data.nome_fantasia).attr('readonly',
                                    true);
                            }
                            if (data.razao_social != '') {
                                $('input[name="corporate_name"]').val(data.razao_social).attr(
                                    'readonly', true);
                            }
                        },
                        error: function(data) {
                            $('input[name="name"]').val('').attr('readonly', false);
                            $('input[name="corporate_name"]').val('').attr('readonly', false);
                        }
                    });
                }
            });
        });
    </script>
@endsection
