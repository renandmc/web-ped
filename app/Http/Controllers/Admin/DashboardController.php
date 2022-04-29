<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'companies' => Company::all(),
            'myCompanies' => User::find(Auth::id())->companies,
            'products' => Product::all(),
            'orders' => [],
        ]);
    }
}
