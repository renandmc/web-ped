<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Company;

class ProductController extends Controller
{
    public function index(Company $company)
    {
        $products = Product::where('company_id', $company->id)->get();
        return view('admin.product.index', [
            'products' => $products,
            'company' => $company,
        ]);
    }

    public function create(Company $company)
    {
        return view('admin.product.create', [
            'company' => $company,
        ]);
    }

    public function store(StoreProductRequest $request, Company $company)
    {
        $company->products()->create($request->validated());
        return redirect()
            ->route('companies.products.index', $company)
            ->with('success', 'Produto criado com sucesso!');
    }

    public function show(Product $product)
    {
        return view('admin.product.show', [
            'product' => $product,
        ]);
    }

    public function edit(Product $product)
    {
        return view('admin.product.edit', [
            'product' => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->fill($request->validated());
        $product->save();
        return redirect()
            ->route('companies.products.index', $product->company)
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $company = $product->company;
        $product->delete();
        return redirect()
            ->route('companies.products.index', $company)
            ->with('success', 'Produto excluído com sucesso!');
    }
}
