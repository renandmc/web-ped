@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Solicitar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Solicitar</li>
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
                                <span class="badge badge-secondary">{{ count($sellers) }}</span>
                            </a>
                        @endforeach
                    </div>
                </x-adminlte-card>
            </div>
            <div class="col-9">
                <x-adminlte-card>
                    <div class="tab-content">
                        @foreach ($companies as $company)
                            <div class="tab-pane fade" id="c-{{ $company->id }}">
                                @php
                                    $heads = [['label' => 'Status', 'width' => 20], 'Empresa', ['label' => 'Opções', 'width' => 20]];
                                    $config = [
                                        'order' => [[0, 'asc'], [1, 'asc']],
                                        'columns' => [null, null, ['orderable' => false, 'searchable' => false]],
                                    ];
                                @endphp
                                <x-adminlte-datatable id="t-c-{{ $company->id }}" :heads="$heads" :config="$config"
                                    hoverable beautify>
                                    @forelse ($sellers as $seller)
                                        @if ($seller->buyers->contains($company))
                                            @php
                                                $buyer = $seller->buyers->find($company->id);
                                                $status = $buyer->pivot->status;
                                                $class = $status == 'Pendente' ? 'warning' : ($status == 'Ativo' ? 'success' : 'danger');
                                                $label = $status == 'Pendente' ? 'Aguardar' : ($status == 'Inativo' ? 'Solicitar' : '');
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span class="badge badge-{{ $class }}">
                                                        {{ $status }}
                                                    </span>
                                                </td>
                                                <td>{{ $seller->name }}</td>
                                                <td>
                                                    <a href="#">{{ $label }}</a>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>
                                                    <span class="badge badge-secondary">
                                                        Sem vínculo
                                                    </span>
                                                </td>
                                                <td>{{ $seller->name }}</td>
                                                <td>
                                                    <a href="#">Solicitar</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="3">Nenhum vínculo disponível</td>
                                        </tr>
                                    @endforelse
                                </x-adminlte-datatable>
                            </div>
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
