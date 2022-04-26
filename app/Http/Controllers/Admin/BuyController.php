<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BuyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Company $company): View
    {
        return view('admin.buy.index', [
            'company' => $company
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCompanyRequest  $request
     * @return Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();
        $validated['owner_id'] = $request->user()->id;

        Company::create($validated);

        return redirect()->route('companies.index')->with('success', 'Empresa cadastrada com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return Response
     */
    public function show(Company $company)
    {
        return view('admin.company.show', [
            'company' => $company
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return Response
     */
    public function edit(Company $company)
    {
        return view('admin.company.edit', [
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompanyRequest  $request
     * @param  \App\Models\Company  $company
     * @return Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $validated = $request->validated();

        $company->fill($validated);

        $company->save();

        return redirect()->route('companies.index')->with('success', 'Empresa atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return Response
     */
    public function destroy(Company $company)
    {
        $company->active = false;

        $company->save();

        return redirect()->route('companies.index')->with('success', 'Empresa desativada com sucesso');
    }
}
