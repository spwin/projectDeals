<?php

namespace App\Http\Controllers\Admin;

use App\Deal;
use App\File;
use App\Http\Controllers\Controller;
use App\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ListingsController extends Controller
{
    private $paginate = 20;

    public function index(Listing $listing, Request $request){
        $listings = $listing->newQuery()->with('deal', 'deal.company', 'sliderImage', 'menuImage');
        if($search = $request->get('q')){
            $listings->orWhereHas('deal', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })->orWhereHas('deal.company', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
            });
            if(is_numeric($search)){
                $listings->orWhere('listings.id', '=', $search);
            }
        }
        $listings = $listings->orderByDesc('id')->paginate($this->paginate);

        return view('admin.pages.listings.list')->with([
            'listings' => $listings
        ]);
    }

    public function create(Deal $deals){
        return view('admin.pages.listings.create')->with([
            'deals' => $deals->all()
        ]);
    }

    public function add(Request $request){
        $request->validate([
            'coupons_count' => 'required',
            'weeks' => 'required|numeric',
            'deal_id' => 'required',
            'slider_image_file' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif',
            'menu_image_file' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $listing = new Listing();
        $listing->fill($request->all());

        $friyayTime = friyayTime();
        $listing->fill([
            'starts_at' => date('Y-m-d H:i:s', $friyayTime),
            'ends_at' => date('Y-m-d H:i:s', addWeeks($friyayTime, $request->get('weeks')))
        ]);
        $listing->save();

        if($request->file('slider_image_file') && $request->file('slider_image_file')->isValid()) {
            $file = new File();
            $file->saveFile('listings_sliders', $request->file('slider_image_file'));
            $listing->fill(['slider_image_id' => $file->getAttribute('id')]);
            $listing->save();
        }
        if($request->file('menu_image_file') && $request->file('menu_image_file')->isValid()) {
            $file = new File();
            $file->saveFile('listings_menu', $request->file('menu_image_file'));
            $listing->fill(['menu_image_id' => $file->getAttribute('id')]);
            $listing->save();
        }

        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', 'Listing has been created');
        return redirect()->route('admin.listings.list');
    }


    public function edit($id, Listing $listings, Deal $deals){
        $listing = $listings->newQuery()->with('deal', 'sliderImage', 'menuImage')->findOrFail($id);
        return view('admin.pages.listings.edit')->with([
            'listing' => $listing,
            'deals' => $deals->all()
        ]);
    }

    public function save($id, Request $request, Listing $listings){
        $rules = [
            'weeks' => 'required',
            'coupons_count' => 'required',
            'deal_id' => 'required'
        ];

        if($request->get('slider_image_file')){
            $rules['slider_image_file'] = 'image|mimes:jpeg,png,jpg,gif';
        }
        if($request->get('menu_image_file')){
            $rules['menu_image_file'] = 'image|mimes:jpeg,png,jpg,gif';
        }

        $request->validate($rules);

        $listing = $listings->newQuery()->with('sliderImage', 'menuImage')->findOrFail($id);
        $listing->fill($request->all());
        if(!$request->get('slider_image')){
            $listing->fill(['slider_image' => false]);
        }
        if(!$request->get('menu_image')){
            $listing->fill(['menu_image' => false]);
        }
        if(!$request->get('best_deals')){
            $listing->fill(['best_deals' => false]);
        }
        if(!$request->get('category_featured')){
            $listing->fill(['category_featured' => false]);
        }
        if(!$request->get('follow_link')){
            $listing->fill(['follow_link' => false]);
        }
        $listing->save();

        if($request->file('slider_image_file') && $request->file('slider_image_file')->isValid()) {
            if($existing_image = $listing->getRelation('sliderImage')){
                $existing_image->deleteFile();
            }
            $file = new File();
            $file->saveFile('listings_sliders', $request->file('slider_image_file'));
            $listing->fill(['slider_image_id' => $file->getAttribute('id')]);
            $listing->save();
        }
        if($request->file('menu_image_file') && $request->file('menu_image_file')->isValid()) {
            if($existing_image = $listing->getRelation('menuImage')){
                $existing_image->deleteFile();
            }
            $file = new File();
            $file->saveFile('listings_menu', $request->file('menu_image_file'));
            $listing->fill(['menu_image_id' => $file->getAttribute('id')]);
            $listing->save();
        }

        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', 'Listing details have been saved');
        return redirect()->route('admin.listings.list');
    }

    public function delete($id, Listing $listings){
        $listing = $listings->newQuery()->with('sliderImage', 'menuImage')->findOrFail($id);
        try {
            if($image = $listing->getRelation('sliderImage')){
                $image->deleteFile();
            }
            if($image = $listing->getRelation('menuImage')){
                $image->deleteFile();
            }
            $listing->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return redirect()->route('admin.listings.list');
    }
}
