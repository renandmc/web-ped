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
            <div class="col-md-3">
                <img src="" alt="">
            </div>
            <div class="col-md-9">
                <h2 class="card-title">{{ Auth::user()->name }}</h2>
                <p class="card-text">{{ Auth::user()->email }}</p>
                <p class="card-text">{{ Auth::user()->created_at }}</p>
            </div>
        </div>
    </x-adminlte-card>
@endsection
