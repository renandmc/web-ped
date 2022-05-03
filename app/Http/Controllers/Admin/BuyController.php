<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BuyController extends Controller
{
    public function index(): View
    {
        $companies = Company::where('owner_id', Auth::id())
            ->where('active', true)
            ->with('sellersActive')
            ->get();
        return view('admin.buy.index', [
            'companies' => $companies
        ]);
    }

    public function products(Request $request, Company $buyer, Company $seller): View
    {
        $cart = $request->session()->get('cart', []);
        return view('admin.buy.products', [
            'buyer' => $buyer,
            'seller' => $seller,
            'cart' => $cart
        ]);
    }

    public function addToCart(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart');
        if (!$cart) {
            $cart = [
                $product->id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image_url" => $product->image_url
                ]
            ];
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Produto adicionado!');
        }
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Produto adicionado!');
        }
        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image_url" => $product->image_url
        ];
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produto adicionado!');
    }
}
