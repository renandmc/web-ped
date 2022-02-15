@extends('adminlte::page')

@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1>{{ __('Profile') }}</h1>
        </div>
        <div class="col-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
                </li>
                <li class="breadcrumb-item active">{{ __('Profile') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <x-adminlte-card>
        <div class="row">
            <div class="col-md-3 text-center my-auto">
                <img src="https://i.pravatar.cc/200?u={{ Auth::user()->email }}" alt="Foto perfil {{ Auth::user()->name }}" class="img-circle elevation-2">
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-8">
                        <h2>{{ Auth::user()->name }}</h2>
                        <p class="text-muted">Cadastrado em {{ Auth::user()->created_at->isoFormat('L') }}</p>
                        <p>
                            <a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>
                        </p>
                        <hr>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Explicabo, error fuga ipsam nisi dignissimos a ex laudantium necessitatibus aut odio quod doloribus reiciendis cupiditate quaerat soluta deleniti consequatur temporibus porro?</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas ipsam suscipit obcaecati enim dolorum similique exercitationem. Odio quo accusamus impedit odit dignissimos tempora nam fugiat quae, quasi quas quos pariatur.</p>
                    </div>
                    <div class="col-4 my-auto">
                        <a href="#" class="btn btn-block btn-default">
                            <i class="fa fa-edit"></i>
                            Alterar dados
                        </a>
                        <a href="#" class="btn btn-block btn-default">
                            <i class="fa fa-key"></i>
                            Alterar senha
                        </a>
                        <a href="#" class="btn btn-block btn-default">
                            <i class="fa fa-envelope"></i>
                            Alterar e-mail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-adminlte-card>
@endsection
