<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Http\Controllers\Controller;
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
}
