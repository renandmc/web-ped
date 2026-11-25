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

        $buyer = Company::findOrFail($request->buyer);
        $seller = Company::findOrFail($request->seller);

        // Only the buyer's owner can request a partnership, and never with a company they own
        $this->authorize('update', $buyer);
        abort_if(!$seller->active || (int) $seller->owner_id === (int) Auth::id(), 403);

        $buyer->sellers()->attach($seller->id);

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
            'buyer' => 'required|integer',
            'status' => 'required|string|in:Ativo,Inativo'
        ]);

        $buyer = Company::findOrFail($request->buyer);
        $seller = Company::findOrFail($request->seller);

        // Only the seller's owner can approve or change a partnership
        $this->authorize('update', $seller);

        // attach() would violate the unique (buyer_id, seller_id) key on an existing partnership
        $buyer->sellers()->syncWithoutDetaching([$seller->id => ['status' => $request->status]]);

        return redirect()->back()->with('success', 'Parceiro atualizado com sucesso!');
    }
}
