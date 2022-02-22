@extends('adminlte::page')

@section('content_header')
    <div class="row">
        <div class="col-12 col-md-6">
            <h1>Alterar dados</h1>
        </div>
        <div class="col-12 col-md-6">
            <ol class="breadcrumb float-md-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.user.profile') }}">{{ __('Profile') }}</a>
                </li>
                <li class="breadcrumb-item active">Alterar dados</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <x-adminlte-card>
        <form action="{{ route('admin.user.update-profile') }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-12 col-md-6">
                    <x-adminlte-input name="name" label="Nome" value="{{ old('name') ?? $user->name }}" required />
                </div>
                <div class="col-12 col-md-6">
                    <x-adminlte-input name="email" label="E-mail" value="{{ old('email') ?? $user->email }}" required />
                </div>
            </div>
            <div class="float-right">
                <a href="{{ route('admin.user.profile') }}" class="btn btn-default">Cancelar</a>
                <x-adminlte-button label="Alterar" theme="primary" type="submit" />
            </div>
        </form>
    </x-adminlte-card>
@endsection
