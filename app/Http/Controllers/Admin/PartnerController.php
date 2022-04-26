<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function approve(): View
    {
        $companies = Company::where('owner_id', Auth::id())
            ->where('active', true)->get();

        return view('admin.partner.approve', [
            'companies' => $companies
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function create(): View
    {
        $companies = Company::where('owner_id', Auth::id())
            ->where('active', true)->get();
        $sellers = Company::where('owner_id', '!=', Auth::id())
            ->where('active', true)->get();

        return view('admin.partner.create', [
            'companies' => $companies,
            'sellers' => $sellers
        ]);
    }

    /**
     * Create an association (partners) between two companies.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'seller' => 'required|integer',
            'buyer' => 'required|integer'
        ]);

        $buyer = Company::find($request->buyer);
        $buyer->sellers()->attach($request->seller);

        $buyer->save();

        return redirect()->back()->with('success', 'Parceiro adicionado com sucesso!');
    }

    /**
     * Update an association (partners) between two companies.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'seller' => 'required|integer',
            'buyer' => 'required|integer'
        ]);

        $buyer = Company::find($request->buyer);
        $buyer->sellers()->updateExistingPivot($request->seller, ['status' => 'Ativo']);

        $buyer->save();

        return redirect()->back()->with('success', 'Parceiro aprovado com sucesso!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'seller' => 'required|integer',
            'buyer' => 'required|integer'
        ]);

        $buyer = Company::find($request->buyer);
        $buyer->sellers()->detach($request->seller);

        $buyer->save();

        return redirect()->back()->with('success', 'Parceiro removido com sucesso!');
    }
}
