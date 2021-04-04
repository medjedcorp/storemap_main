<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class DataPageController extends Controller
{
    public function ItemData()
    {
        $user = Auth::user();
        $company = Company::find($user->company_id);
        return view('items.data', [
            'company' => $company,
        ]);
    }

    public function CatalogData()
    {
        $user = Auth::user();
        $company = Company::find($user->company_id);
        return view('catalog.data', [
            'company' => $company,
        ]);
    }
}
