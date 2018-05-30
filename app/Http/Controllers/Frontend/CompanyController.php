<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Company;
use App\Http\Controllers\Controller;
use App\Listing;

class CompanyController extends Controller
{
    public function view($id, $slug, Company $companies){
        $company = $companies->newQuery()->with('deals.listings')
            ->where(['id' => $id, 'slug' => $slug])->first();
        return view('frontend.pages.company')->with([
            'company' => $company
        ]);
    }
}
