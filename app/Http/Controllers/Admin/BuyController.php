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
        $cartName = "cart-$buyer->id-$seller->id";
        $cart = $request->session()->get($cartName, []);
        return view('admin.buy.products', [
            'buyer' => $buyer,
            'seller' => $seller,
            $cartName => $cart
        ]);
    }

    public function addToCart(Request $request, Product $product)
    {
        $cartName = "cart-$request->buyer-$request->seller";
        $cart = $request->session()->get($cartName);
        if (!$cart) {
            $cart = [
                $product->id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image_url" => $product->image_url
                ]
            ];
            session()->put($cartName, $cart);
            return redirect()->back()->with('success', 'Produto adicionado!');
        }
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
            session()->put($cartName, $cart);
            return redirect()->back()->with('success', 'Produto adicionado!');
        }
        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image_url" => $product->image_url
        ];
        session()->put($cartName, $cart);
        return redirect()->back()->with('success', 'Produto adicionado!');
    }

    public function remove(Request $request)
    {
        $cartName = "cart-$request->buyer-$request->seller";
        if ($request->id) {
            $cart = $request->session()->get($cartName);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                $request->session()->put($cartName, $cart);
            }
            return $request->session()->flash('success', 'Produto removido!');
        }

    }
}
