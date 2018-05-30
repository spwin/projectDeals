<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Listing;

class ListingController extends Controller
{
    public function index($id, $slug, Listing $listings){
        $listing = $listings->newQuery()->with('deal', 'deal.image', 'deal.company', 'deal.map', 'deal.gallery', 'deal.reviews')
            ->where(['id' => $id])->whereHas('deal', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })->first();
        if(!$listing){
            return abort(404);
        }
        if(!$listing->getAttribute('valid')){
            return abort(404);
        }
        return view('frontend.pages.listing')->with([
            'listing' => $listing
        ]);
    }
}
