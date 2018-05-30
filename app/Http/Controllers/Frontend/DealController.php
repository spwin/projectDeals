<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    public function rate($id, Request $request, Listing $listings){
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|max:1000'
        ]);

        $listing = $listings->newQuery()->with('deal', 'deal.reviews')->findOrFail($id);
        $deal = $listing->getRelation('deal');

        $user = Auth::guard('user')->user();

        $request->merge(['date' => date('Y-m-d H:i:s', time())]);
        $user->reviews()->attach($deal->getAttribute('id'), $request->except('_token'));

        $ratings = $deal->getRelation('reviews')->pluck('pivot.rating');
        $ratings->push(intval($request->get('rating')));

        $deal->fill(['rating' => $ratings->avg()]);
        $deal->save();

        return redirect()->back();
    }
}
