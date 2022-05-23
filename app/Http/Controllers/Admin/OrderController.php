<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function sent(Request $request)
    {
        $companies = Company::where('owner_id', Auth::id())
            ->where('active', true)
            ->with([
                'adresses',
                'ordersSent',
                'ordersSent.buyer',
                'ordersSent.seller',
                'ordersSent.address',
                'ordersSent.items',
                'ordersSent.items.product'
            ])
            ->get();
        return view('admin.orders.sent', [
            'companies' => $companies
        ]);
    }

    public function received(Request $request)
    {
        $companies = Company::where('owner_id', Auth::id())
            ->with([
                'ordersReceived',
                'ordersReceived.buyer',
                'ordersReceived.seller',
                'ordersReceived.items',
                'ordersReceived.items.product',
            ])
            ->get();
        return view('admin.orders.received', [
            'companies' => $companies
        ]);
    }

    public function details(Request $request, Order $order)
    {
        $order->load([
            'buyer',
            'seller',
            'address',
            'items',
            'items.product'
        ]);
        return view('admin.orders.details', [
            'order' => $order
        ]);
    }
}
