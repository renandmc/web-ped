@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-12 col-md-6">
                <h1>{{ __('Profile') }}</h1>
            </div>
            <div class="col-12 col-md-6">
                <ol class="breadcrumb float-md-right">
                    <li class="breadcrumb-item active">{{ __('Profile') }}</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        <div class="row">
            <div class="col-12 col-md-3 my-md-auto text-center">
                <img src="{{ $user->adminlte_image() }}" alt="Foto perfil {{ $user->name }}" class="img-rounded mw-75">
            </div>
            <div class="col-12 col-md-9 my-md-auto">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <h2>{{ $user->name }}</h2>
                        <p class="text-muted">Cadastrado em {{ $user->created_at->isoFormat('L') }}</p>
                        <p>
                            <a href="mailto:{{ $user->email }}" target="_blank"
                                title="Enviar e-mail">{{ $user->email }}</a>
                        </p>
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="{{ route('user.edit-profile') }}" class="btn btn-block btn-default">
                            <i class="fa fa-pen"></i>
                            &nbsp;
                            Alterar dados
                        </a>
                        <a href="{{ route('user.edit-password') }}" class="btn btn-block btn-default">
                            <i class="fa fa-key"></i>
                            &nbsp;
                            Alterar senha
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-adminlte-card>
@endsection
