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
                                    $heads = ['Status', 'Empresa', 'Opções'];
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
                                                $class = $status == 'Pendente' ? 'warning' : 'success';
                                                $label = $status == 'Pendente' ? 'Aguardar confirmação' : '';
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span class="badge badge-{{ $class }}">
                                                        {{ $status }}
                                                    </span>
                                                </td>
                                                <td>{{ $seller->name }}</td>
                                                <td>{{ $label }}</td>
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
                                                    <a href="#" data-toggle="modal" data-target="#modalSolicitacao"
                                                        data-buyer="{{ $company->id }}"
                                                        data-seller="{{ $seller->id }}">
                                                        Solicitar
                                                    </a>
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
    <x-adminlte-modal id="modalSolicitacao" title="Solicitar vínculo">
        <h3>Deseja confirmar a solicitação?</h3>
        <x-slot name="footerSlot">
            <form action="{{ route('partners.store') }}" method="post">
                @csrf
                <input type="hidden" name="seller" value="">
                <input type="hidden" name="buyer" value="">
                <x-adminlte-button type="submit" label="Sim" theme="primary" />
                <x-adminlte-button label="Não" theme="default" data-dismiss="modal" />
            </form>
        </x-slot>
    </x-adminlte-modal>
@endsection

@section('js')
    <script>
        $('#pills a:first-child').tab('show');
        $.extend(true, $.fn.dataTable.defaults, {
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/pt_br.json"
            }
        });
        $('#modalSolicitacao').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let seller = button.data('seller');
            let buyer = button.data('buyer');
            var modal = $(this);
            modal.find('input[name="seller"]').val(seller);
            modal.find('input[name="buyer"]').val(buyer);
        });
    </script>
@endsection
