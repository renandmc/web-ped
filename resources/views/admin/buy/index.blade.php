@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Comprar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.index') }}">Empresas</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.show', $company) }}">{{ $company->name }}</a>
                    </li>
                    <li class="breadcrumb-item active">Comprar</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        @php
            $heads = ['Status', 'Nome', 'CNPJ', 'Opções'];
            $config = [
                'order' => [[0, 'asc'], [1, 'asc']],
                'columns' => [null, null, null, ['orderable' => false, 'searchable' => false]]
            ];
        @endphp
        <x-adminlte-datatable id="tableBuy" :heads="$heads" :config="$config" hoverable beautify>
            @forelse ($companies as $seller)
                @php
                    $active = $seller->buyersActive->contains($company);
                    $pending = $seller->buyersPending->contains($company);
                    $inactive = $seller->buyersInactive->contains($company);
                    $status = $active ? 'success' : ($pending ? 'warning' : ($inactive ? 'danger' : 'secondary'));
                    $statusName = $active ? 'Ativo' : ($pending ? 'Pendente' : ($inactive ? 'Inativo' : 'Sem vínculo'));
                @endphp
                <tr>
                    <td>
                        <span class="lead">
                            <span class="badge badge-{{ $status }}">{{ $statusName }}</span>
                        </span>
                    </td>
                    <td>{{ $seller->name }} ({{ $seller->corporate_name ?? '-' }})</td>
                    <td>{{ $seller->cnpj }}</td>
                    <td>
                        @if ($status == 'success')
                            <a href="#" class="btn btn-primary">
                                <i class="fas fa-fw fa-shopping-cart"></i>
                                Comprar
                            </a>
                        @elseif ($status == 'warning')
                            <a href="#" class="btn btn-default text-muted">
                                <i class="fas fa-fw fa-clock"></i>
                                Aguardar aprovação
                            </a>
                        @else
                            <a href="#" class="btn btn-default">
                                <i class="fas fa-fw fa-handshake"></i>
                                Solicitar vínculo
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Nenhuma empresa encontrada</td>
                </tr>
            @endforelse
        </x-adminlte-datatable>
    </x-adminlte-card>
@endsection

@section('js')
    <script>
        $.extend(true, $.fn.dataTable.defaults, {
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/pt_br.json"
            }
        });
    </script>
@endsection
