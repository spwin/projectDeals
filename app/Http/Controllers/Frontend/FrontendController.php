<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Events\Publish;
use App\Http\Controllers\Controller;
use App\Listing;
use App\Services\FacebookService;

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
