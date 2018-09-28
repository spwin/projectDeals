<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Listing;
use App\Rotation;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class ListingController extends Controller
{
    public function index($id, $slug, Listing $listings){
        $listing = $listings->newQuery()->with('deal', 'deal.image', 'deal.company', 'deal.map', 'deal.gallery', 'deal.reviews', 'participants')
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

    public function participate(int $id, Listing $listings, Rotation $rotation){
        if($user = Auth::guard('user')->user()){
            $listing = $listings->newQuery()->findOrFail($id);
            $currentRotation = $rotation->newQuery()->where(['active' => true])->first();
            try{
                $listing->participants()->save($user, ['rotation_id' => $currentRotation->getAttribute('id')]);
            } catch (QueryException $e) {
                report($e);
            }
            return redirect()->back();
        }
        return abort(403);
    }
}
