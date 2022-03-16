<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Company;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        $products = Product::where('company_id', $company->id)->paginate(5);
        return view('admin.product.index', [
            'products' => $products,
            'company' => $company,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {
        return view('admin.product.create', [
            'company' => $company,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request, Company $company)
    {
        $company->products()->create($request->validated());
        return redirect()->route('admin.company.product.index', $company)->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.product.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->fill($request->validated());
        $product->save();
        return redirect()
            ->route('companies.products.index', $product->company)
            ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $company = $product->company;
        $product->delete();
        return redirect()
            ->route('companies.products.index', $company)
            ->with('success', 'Produto excluído com sucesso!');
    }
}
