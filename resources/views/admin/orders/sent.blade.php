@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Pedidos enviados</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Pedidos enviados</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <x-adminlte-card>
        @if (count($companies) > 0)
            @php
                $heads = ['Status', 'Data/hora', 'Código', 'Comprador', 'Vendedor', 'Total', 'Opções'];
                $config = [
                    'order' => [[0, 'asc'], [1, 'asc']],
                    'columns' => [null, null, null, null, null, null, ['orderable' => false, 'searchable' => false]],
                    'lengthMenu' => [[5, 10, 15, -1], [5, 10, 15, 'Todos']],
                ];
            @endphp
            <x-adminlte-datatable id="tableOrders" :heads="$heads" :config="$config" beautify with-buttons>
                @foreach ($companies as $company)
                    @foreach ($company->ordersSent as $order)
                        <tr>
                            <td>
                                @php
                                    $badge = '';
                                    switch ($order->status) {
                                        case 'Aprovado':
                                            $badge = 'success';
                                            break;
                                        case 'Cancelado':
                                            $badge = 'danger';
                                            break;
                                        case 'Entregue':
                                            $badge = 'primary';
                                            break;
                                        default:
                                            $badge = 'warning';
                                            break;
                                    }
                                @endphp
                                <span class="badge badge-{{ $badge }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>Pedido #{{ $order->id }}</td>
                            <td>
                                <a href="{{ route('companies.show', $company) }}">
                                    <b>{{ $company->name }}</b>
                                </a>
                            </td>
                            <td><b>{{ $order->seller->name }}</b></td>
                            <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('orders.sent.details', $order) }}" class="btn btn-default">
                                    <i class="fas fa-fw fa-info"></i>
                                    Detalhes
                                </a>
                                @if ($order->status == 'Pendente')
                                    <a href="{{ route('orders.received.reject', $order) }}" class="btn btn-danger">
                                        <i class="fas fa-fw fa-times"></i>
                                        Cancelar
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </x-adminlte-datatable>
        @else
            <p class="card-text">
                Nenhuma empresa cadastrada, <a href="{{ route('companies.create') }}">cadastrar nova.</a>
            </p>
        @endif
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
