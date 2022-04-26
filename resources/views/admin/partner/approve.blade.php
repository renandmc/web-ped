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
                    <h5>Suas empresas</h5>
                    <hr>
                    <div class="nav flex-column nav-pills" id="pills">
                        @foreach ($companies as $company)
                            <a href="#c-{{ $company->id }}" class="nav-link" data-toggle="pill">
                                {{ $company->name }}
                                &nbsp;
                                @if (count($company->buyersActive) > 0)
                                    <span class="badge badge-success">{{ count($company->buyersActive) }}</span>
                                @endif
                                @if (count($company->buyersPending) > 0)
                                    <span class="badge badge-warning">{{ count($company->buyersPending) }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </x-adminlte-card>
            </div>
            <div class="col-9">
                <x-adminlte-card>
                    <h5>Solicitações</h5>
                    <hr>
                    <div class="tab-content">
                        @foreach ($companies as $company)
                            @if (count($company->buyers) > 0)
                                <div class="tab-pane fade" id="c-{{ $company->id }}">
                                    @php
                                        $heads = ['Status', 'Empresa', 'Opções'];
                                        $config = [
                                            'order' => [[0, 'asc'], [1, 'asc']],
                                            'columns' => [null, null, ['orderable' => false, 'searchable' => false]],
                                            'lengthMenu' => [[5, 10, 25], [5, 10, 25]],
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
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#modal{{ $label == 'Aprovar' ? 'Approve' : 'Remove' }}"
                                                        data-buyer="{{ $buyer->id }}"
                                                        data-seller="{{ $company->id }}"
                                                        data-option="{{ $label }}">
                                                        {{ $label }}
                                                    </a>
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
                                    <p class="card-text">Nenhuma solicitação</p>
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
    <x-adminlte-modal id="modalApprove" title="Aprovar vínculo">
        <h3>Deseja aprovar a solicitação?</h3>
        <x-slot name="footerSlot">
            <form action="{{ route('partners.update') }}" method="post">
                @csrf
                @method('put')
                <input type="hidden" name="seller" value="">
                <input type="hidden" name="buyer" value="">
                <x-adminlte-button type="submit" label="Sim" theme="primary" />
                <x-adminlte-button label="Não" theme="default" data-dismiss="modal" />
            </form>
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalRemove" title="Remover vínculo">
        <h3>Deseja remover o vínculo?</h3>
        <x-slot name="footerSlot">
            <form action="{{ route('partners.destroy') }}" method="post">
                @csrf
                @method('delete')
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
        $('#modalApprove').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let seller = button.data('seller');
            let buyer = button.data('buyer');
            var modal = $(this);
            modal.find('input[name="seller"]').val(seller);
            modal.find('input[name="buyer"]').val(buyer);
        });
        $('#modalRemove').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let seller = button.data('seller');
            let buyer = button.data('buyer');
            var modal = $(this);
            modal.find('input[name="seller"]').val(seller);
            modal.find('input[name="buyer"]').val(buyer);
        });
    </script>
@endsection
