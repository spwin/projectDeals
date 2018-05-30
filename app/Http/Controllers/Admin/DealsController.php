<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Deal;
use App\File;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DealsController extends Controller
{
    private $paginate = 20;

    public function index(Deal $deal, Request $request){
        $deals = $deal->newQuery()->with('company');
        if($search = $request->get('q')){
            $deals->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhereHas('company', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        }
        $deals = $deals->orderByDesc('id')->paginate($this->paginate);

        return view('admin.pages.deals.list')->with([
            'deals' => $deals
        ]);
    }

    public function create(Company $companies){
        return view('admin.pages.deals.create')->with([
            'companies' => $companies->all()
        ]);
    }

    public function add(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required|numeric',
            'company_id' => 'required',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif',
            'gallery.*' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $deal = new Deal();
        $deal->fill($request->all());
        $deal->save();

        if($request->file('image') && $request->file('image')->isValid()) {
            $file = new File();
            $file->saveFile('deals', $request->file('image'));
            $deal->fill(['image_id' => $file->getAttribute('id')]);
            $deal->save();
        }

        // Save gallery
        if($gallery = $request->file('gallery')){
            foreach($gallery as $order => $image){
                if($image->isValid()){
                    $file = new File();
                    $file->saveFile('deal_gallery', $image);
                    $deal->gallery()->attach($file->getAttribute('id'), ['order' => $order]);
                }
            }
        }

        // Generate Google maps image
        if($location = collect($request->get('location'))){
            if($location->get('lon') && $location->get('lat')) {
                $map = generateMap($location);
                $deal->fill(['map' => $map->getAttribute('id')]);
                $deal->save();
            }
        }

        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', 'Deal has been created');
        return redirect()->route('admin.deals.list');
    }


    public function edit($id, Deal $deals, Company $companies){
        $deal = $deals->newQuery()->with('company', 'image', 'gallery', 'map')->findOrFail($id);
        return view('admin.pages.deals.edit')->with([
            'deal' => $deal,
            'companies' => $companies->all()
        ]);
    }

    public function save($id, Request $request, Deal $deals){
        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required|numeric',
            'company_id' => 'required'
        ];

        if($request->get('image')){
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif';
        }

        $request->validate($rules);

        $deal = $deals->newQuery()->with('image', 'gallery', 'map')->findOrFail($id);
        $old_location = $deal->getAttribute('location');
        $deal->fill($request->all());
        $deal->save();

        if($request->file('image') && $request->file('image')->isValid()) {
            if($existing_image = $deal->getRelation('image')){
                $existing_image->deleteFile();
            }
            $file = new File();
            $file->saveFile('deals', $request->file('image'));
            $deal->fill(['image_id' => $file->getAttribute('id')]);
            $deal->save();
        }

        // Save gallery
        if($delete = $request->get('delete_gallery')){
            foreach($delete as $order => $file_id){
                $file = $deal->getRelation('gallery')->where('id', $file_id)->first();
                $file->deleteFile();
            }
        }
        if($gallery = $request->file('gallery')){
            foreach($gallery as $order => $image){
                if($image->isValid()){
                    $file = new File();
                    $file->saveFile('deal_gallery', $image);
                    $deal->gallery()->attach($file->getAttribute('id'), ['order' => $order]);
                }
            }
        }

        // Generate Google maps image
        if($location = collect($request->get('location'))){
            if($location->get('lon') && $location->get('lat')) {
                if($current_map = $deal->getRelation('map')) {
                    if($location->get('lon') != $old_location->get('lon') || $location->get('lat') != $old_location->get('lat')) {
                        $current_map->deleteFile();
                        $map = generateMap($location);
                        $deal->fill(['map_id' => $map->getAttribute('id')]);
                        $deal->save();
                    }
                } else {
                    $map = generateMap($location);
                    $deal->fill(['map_id' => $map->getAttribute('id')]);
                    $deal->save();
                }
            } elseif($current_map = $deal->getRelation('map')) {
                $current_map->deleteFile();
            }
        }

        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', 'Deal details have been saved');
        return redirect()->back();
    }

    public function delete($id, Deal $deals){
        $deal = $deals->newQuery()->with('image')->findOrFail($id);
        try {
            if($image = $deal->getRelation('image')){
                $image->deleteFile();
            }
            $deal->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return redirect()->route('admin.deals.list');
    }
}
