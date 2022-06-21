<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $chartData = [];

        $companies = Company::all();
        $myCompanies = Company::where('owner_id', Auth::id())->get();
        $products = Product::all();
        $orders = Order::all();
        $myOrders = Order::whereIn('buyer_id', function($query) {
            $query->select('id')->from(with(new Company())->getTable())->where('owner_id', Auth::id());
        })->latest()->take(5)->get();

        $dataCompanies = [];
        $dataCompanies['total'] = count($companies);
        $dataCompanies['my'] = count($myCompanies);
        $dataCompanies['active'] = 0;
        $dataCompanies['inactive'] = 0;
        foreach ($companies as $company) {
            $dataCompanies['active'] = $company->active ? $dataCompanies['active'] + 1 : $dataCompanies['active'];
            $dataCompanies['inactive'] = $company->active ? $dataCompanies['inactive'] : $dataCompanies['inactive'] + 1;
        }
        $chartData['companies'] = $dataCompanies;

        $dataProducts = [];
        $dataProducts['total'] = count($products);
        $dataProducts['active'] = 0;
        $dataProducts['inactive'] = 0;
        foreach ($products as $product) {
            $dataProducts['active'] = $product->active ? $dataProducts['active'] + 1 : $dataProducts['active'];
            $dataProducts['inactive'] = $product->active ? $dataProducts['inactive'] : $dataProducts['inactive'] + 1;
        }
        $chartData['products'] = $dataProducts;

        $dataOrders = [];
        $dataOrders['total'] = count($orders);
        $dataOrders['approved'] = 0;
        $dataOrders['pending'] = 0;
        $dataOrders['rejected'] = 0;
        foreach ($orders as $order) {
            $dataOrders['approved'] = $order->status == 'Aprovado' ? $dataOrders['approved'] + 1 : $dataOrders['approved'];
            $dataOrders['pending'] = $order->status == 'Pendente' ? $dataOrders['pending'] + 1 : $dataOrders['pending'];
            $dataOrders['rejected'] = $order->status == 'Cancelado' ? $dataOrders['rejected'] + 1 : $dataOrders['rejected'];
        }
        $chartData['orders'] = $dataOrders;

        $chartData['users']['total'] = User::count();

        $sellers = [];
        $sellers['pending'] = 0;
        $sellers['approved'] = 0;
        $buyers = [];
        $buyers['pending'] = 0;
        $buyers['approved'] = 0;
        foreach ($myCompanies as $company) {
            $sellers['pending'] = $sellers['pending'] + count($company->sellersPending);
            $sellers['approved'] = $sellers['approved'] + count($company->sellersActive);
            $buyers['pending'] = $buyers['pending'] + count($company->buyersPending);
            $buyers['approved'] = $buyers['approved'] + count($company->buyersActive);
        }
        $chartData['partners']['sellers'] = $sellers;
        $chartData['partners']['buyers'] = $buyers;
        return view('admin.dashboard', [
            'chartData' => $chartData,
            'myOrders' => $myOrders,
        ]);
    }
}
