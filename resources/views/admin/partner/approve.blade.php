@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Aprovar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Aprovar</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <div class="row">
        @if (count($companies) > 0)
            <div class="col-3">
                <x-adminlte-card>
                    <div class="nav flex-column nav-pills" id="pills">
                        @foreach ($companies as $company)
                            <a href="#c-{{ $company->id }}" class="nav-link" data-toggle="pill">
                                {{ $company->name }}
                                &nbsp;
                                <span class="badge badge-secondary">{{ count($company->buyers) }}</span>
                            </a>
                        @endforeach
                    </div>
                </x-adminlte-card>
            </div>
            <div class="col-9">
                <x-adminlte-card>
                    <div class="tab-content">
                        @foreach ($companies as $company)
                            @if (count($company->buyers) > 0)
                                <div class="tab-pane fade" id="c-{{ $company->id }}">
                                    @php
                                        $heads = ['Status', 'Empresa', 'Opções'];
                                        $config = [
                                            'order' => [[0, 'asc'], [1, 'asc']],
                                            'columns' => [null, null, ['orderable' => false, 'searchable' => false]],
                                        ];
                                    @endphp
                                    <x-adminlte-datatable id="t-c-{{ $company->id }}" :heads="$heads" :config="$config"
                                        hoverable beautify>
                                        @forelse ($company->buyers as $buyer)
                                            @php
                                                $status = $buyer->pivot->status;
                                                $class = $status == 'Pendente' ? 'warning' : 'success';
                                                $label = $status == 'Pendente' ? 'Aprovar' : 'Remover';
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span class="badge badge-{{ $class }}">
                                                        {{ $status }}
                                                    </span>
                                                </td>
                                                <td>{{ $buyer->name }}</td>
                                                <td>
                                                    <a href="#">{{ $label }}</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">Nenhum vínculo</td>
                                            </tr>
                                        @endforelse
                                    </x-adminlte-datatable>
                                </div>
                            @else
                                <div class="tab-pane fade" id="c-{{ $company->id }}">
                                    <p class="card-text">Nenhum vínculo</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </x-adminlte-card>
            </div>
        @else
            <div class="col-12">
                <x-adminlte-card>
                    <p class="card-text">Nenhuma empresa cadastrada</p>
                </x-adminlte-card>
            </div>
        @endif
    </div>
@endsection

@section('js')
    <script>
        $('#pills a:first-child').tab('show');
        $.extend(true, $.fn.dataTable.defaults, {
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/pt_br.json"
            }
        });
    </script>
@endsection
