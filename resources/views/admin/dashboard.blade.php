@extends('adminlte::page')

@section('content_header')
    <x-adminlte-card>
        <div class="row">
            <div class="col-sm-6">
                <h1>Painel</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Painel</li>
                </ol>
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <x-adminlte-small-box title="{{ $chartData['companies']['total'] }}" text="Empresas" icon="fas fa-lg fa-building"
                url="{{ route('companies.index') }}" url-text="Minhas empresas" theme="primary" />
        </div>
        <div class="col-lg-3">
            <x-adminlte-small-box title="{{ $chartData['products']['total'] }}" text="Produtos" icon="fas fa-lg fa-box-open"
                url="{{ route('companies.index') }}" url-text="Minhas empresas" theme="primary" />
        </div>
        <div class="col-lg-3">
            <x-adminlte-small-box title="{{ $chartData['orders']['total'] }}" text="Pedidos" icon="fas fa-lg fa-shopping-cart"
                url="{{ route('orders.sent') }}" url-text="Meus pedidos" theme="primary" />
        </div>
        <div class="col-lg-3">
            <x-adminlte-small-box title="{{ $chartData['users']['total'] }}" text="Usuários" icon="fas fa-lg fa-users"
                url="{{ route('user.profile') }}" url-text="Perfil" theme="primary" />
        </div>
        <div class="col-lg-6">
            <x-adminlte-card title="Empresas" collapsible>
                <div class="row">
                    <div class="col-6">
                        <canvas id="companiesChart"></canvas>
                    </div>
                    <div class="col-6">
                        <canvas id="productsChart"></canvas>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
        <div class="col-lg-6">
            <x-adminlte-card title="Pedidos" collapsible>
                <div class="row">
                    <div class="col-6">
                        <canvas id="ordersChart"></canvas>
                    </div>
                    <div class="col-6">
                        <p class="card-text">Gráfico pedidos por mês</p>
                        <canvas id="ordersMonthChart"></canvas>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
        <div class="col-lg-6">
            <x-adminlte-card title="Vínculos" collapsible>
                <div class="row">
                    <div class="col-6">
                        <canvas id="sellersChart"></canvas>
                    </div>
                    <div class="col-6">
                        <canvas id="buyersChart"></canvas>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const canvasCompanies = document.getElementById('companiesChart');
        const canvasProducts = document.getElementById('productsChart');
        const canvasOrders = document.getElementById('ordersChart');
        const canvasSellers = document.getElementById("sellersChart");
        const canvasBuyers = document.getElementById("buyersChart");
        const dataCompanies = {
            labels: ["Ativas", "Inativas"],
            datasets: [{
                data: [{{ $chartData['companies']['active'] }}, {{ $chartData['companies']['inactive'] }}],
                backgroundColor: ['#007bff', '#dc3545'],
            }]
        };
        const dataProducts = {
            labels: ["Disponíveis", "Indisponíveis"],
            datasets: [{
                data: [{{ $chartData['products']['active'] }}, {{ $chartData['products']['inactive'] }}],
                backgroundColor: ["#00b300", "#dc3545"],
            }]
        };
        const dataOrders = {
            labels: ["Aprovados", "Pendentes", "Cancelados"],
            datasets: [{
                data: [{{ $chartData['orders']['approved'] }}, {{ $chartData['orders']['pending'] }}, {{ $chartData['orders']['rejected'] }}],
                backgroundColor: ["#00b300", "#ffd633", "#dc3545"],
            }]
        };
        const dataSellers = {
            labels: ["Aprovados", "Pendentes"],
            datasets: [{
                data: [{{ $chartData['partners']['sellers']['approved'] }}, {{ $chartData['partners']['sellers']['pending'] }}],
                backgroundColor: ["#00b300", "#ffd633"],
            }]
        };
        const dataBuyers = {
            labels: ["Aprovados", "Pendentes"],
            datasets: [{
                data: [{{ $chartData['partners']['buyers']['approved'] }}, {{ $chartData['partners']['buyers']['pending'] }}],
                backgroundColor: ['#00b300', '#ffd633'],
            }]
        };
        const chartCompanies = new Chart(canvasCompanies, {
            type: 'pie',
            data: dataCompanies,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Empresas',
                    }
                }
            }
        });
        const chartProducts = new Chart(canvasProducts, {
            type: 'pie',
            data: dataProducts,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Produtos',
                    }
                }
            }
        });
        const chartOrders = new Chart(canvasOrders, {
            type: 'pie',
            data: dataOrders,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Pedidos',
                    }
                }
            }
        });
        const chartSellers = new Chart(canvasSellers, {
            type: 'pie',
            data: dataSellers,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Meus vendedores',
                    }
                }
            }
        });
        const chartBuyers = new Chart(canvasBuyers, {
            type: 'pie',
            data: dataBuyers,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Meus compradores',
                    }
                }
            }
        });
    </script>
@endsection
