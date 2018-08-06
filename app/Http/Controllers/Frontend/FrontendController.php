<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Http\Controllers\Controller;
use App\Listing;

class FrontendController extends Controller
{
    public function homepage(Category $categories){
        return view('frontend.pages.homepage')->with([
            'categories' => $categories->withCount(['listings' => function ($query) {
                $query->where('valid', true);
            }])->get()
        ]);

    }

    public function static($view){
        return showViewIfExists('frontend.pages.static.'.$view);
    }
}
