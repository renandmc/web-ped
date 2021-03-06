@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-12 col-md-6">
                <h1>Alterar senha</h1>
            </div>
            <div class="col-12 col-md-6">
                <ol class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('user.profile') }}">{{ __('Profile') }}</a>
                    </li>
                    <li class="breadcrumb-item active">Alterar senha</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        <form action="{{ route('user.update-password') }}" method="post">
            @method('put')
            @csrf
            <div class="row">
                <div class="col-12 col-md-6">
                    <x-adminlte-input name="current_password" type="password" label="Senha atual" required />
                </div>
                <div class="col-12 col-md-6">
                    <x-adminlte-input name="new_password" type="password" label="Nova senha" required />
                </div>
                <div class="col-12 col-md-6 offset-md-6">
                    <x-adminlte-input name="new_password_confirmation" type="password" label="Confirme a nova senha"
                        required />
                </div>
            </div>
            <div class="float-right">
                <x-adminlte-button label="Alterar" theme="primary" type="submit" />
            </div>
        </form>
    </x-adminlte-card>
@endsection
