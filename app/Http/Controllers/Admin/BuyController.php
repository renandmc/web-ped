<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Models\CompanyAddress;
use App\Models\Order;
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

    public function products(Request $request, Company $buyer, Company $seller)
    {
        if ($buyer->sellersActive()->where('id', $seller->id)->count() == 0) {
            return redirect()->route('buy');
        } else {
            $cartName = "cart-$buyer->id-$seller->id";
            $cart = $request->session()->get($cartName, []);
            return view('admin.buy.products', [
                'buyer' => $buyer,
                'seller' => $seller,
                $cartName => $cart
            ]);
        }
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

    public function removeAll(Request $request)
    {
        $cartName = "cart-$request->buyer-$request->seller";
        $request->session()->forget($cartName);
        return $request->session()->flash('success', 'Todos os produtos removidos!');
    }

    public function checkout(Request $request, Company $buyer, Company $seller)
    {
        $cartName = "cart-$buyer->id-$seller->id";
        $cart = $request->session()->get($cartName);
        if (!$cart) {
            return redirect()->route('buy');
        }
        $total = 0;
        $items = [];
        foreach ($cart as $id => $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
            $items[] = [
                'id' => $id,
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total_item' => $item['quantity'] * $item['price'],
                'image_url' => $item['image_url']
            ];
        }
        return view('admin.buy.checkout', [
            'buyer' => $buyer,
            'seller' => $seller,
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function confirm(Request $request, Company $buyer, Company $seller)
    {
        $cartName = "cart-$buyer->id-$seller->id";
        if (count($request->products) > 0) {
            $order = Order::create([
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
                'address_id' => $request->address,
                'total' => 0
            ]);
            $total = 0;
            foreach ($request->products as $id => $quantity) {
                $product = Product::find($id);
                $subtotal = $product->price * $quantity;
                $order->items()->create([
                    'product_id' => $id,
                    'quantity' => $quantity,
                    'total_item' => $subtotal
                ]);
                $total += $subtotal;
            }
            $order->total = $total;
            $order->save();
            $request->session()->forget($cartName);
            return redirect()->route('orders.sent')->with('success', 'Pedido realizado com sucesso!');
        } else {
            return redirect()->route('buy');
        }
    }
}
