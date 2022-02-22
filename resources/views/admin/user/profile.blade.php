@extends('adminlte::page')

@section('content_header')
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
@endsection

@section('content')
    <x-adminlte-card>
        <div class="row">
            <div class="col-12 col-md-3 my-md-auto text-center">
                <img src="{{ $user->adminlte_image() }}" alt="Foto perfil {{ $user->name }}" class="img-circle elevation-2 mw-100">
            </div>
            <div class="col-12 col-md-9">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <h2>{{ $user->name }}</h2>
                        <p class="text-muted">Cadastrado em {{ $user->created_at->isoFormat('L') }}</p>
                        <p>
                            <a href="mailto:{{ $user->email }}" target="_blank" title="Enviar e-mail">{{ $user->email }}</a>
                        </p>
                        <hr>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Explicabo, error fuga ipsam nisi dignissimos a ex laudantium necessitatibus aut odio quod doloribus reiciendis cupiditate quaerat soluta deleniti consequatur temporibus porro?</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas ipsam suscipit obcaecati enim dolorum similique exercitationem. Odio quo accusamus impedit odit dignissimos tempora nam fugiat quae, quasi quas quos pariatur.</p>
                    </div>
                    <div class="col-12 col-md-4 my-md-auto">
                        <a href="{{ route('admin.user.edit-profile') }}" class="btn btn-block btn-default">
                            <i class="fa fa-edit"></i>
                            Alterar dados
                        </a>
                        <a href="{{ route('admin.user.edit-password') }}" class="btn btn-block btn-default">
                            <i class="fa fa-key"></i>
                            Alterar senha
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-adminlte-card>
@endsection
