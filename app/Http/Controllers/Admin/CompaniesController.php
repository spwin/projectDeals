<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\File;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompaniesController extends Controller
{
    private $paginate = 20;

    public function index(Company $company, Request $request){
        $companies = $company->newQuery()->with('user');
        if($search = $request->get('q')){
            $companies->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('email', 'like', "%{$search}%");
                });
        }
        $companies = $companies->orderByDesc('id')->paginate($this->paginate);

        return view('admin.pages.companies.list')->with([
            'companies' => $companies
        ]);
    }

    public function create(User $users){
        return view('admin.pages.companies.create')->with([
            'managers' => $users->newQuery()->where('role', '=', 'manager')->get()
        ]);
    }

    public function add(Request $request){
        $request->validate([
            'name' => 'required',
            'user_id' => 'required',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $company = new Company();
        $company->fill($request->all());
        $company->save();

        if($request->file('image') && $request->file('image')->isValid()) {
            $file = new File();
            $file->saveFile('companies', $request->file('image'));
            $company->fill(['image_id' => $file->getAttribute('id')]);
            $company->save();
        }

        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', 'Company has been created');
        return redirect()->route('admin.companies.list');
    }


    public function edit($id, Company $companies, User $users){
        $company = $companies->newQuery()->with('user', 'image')->findOrFail($id);
        return view('admin.pages.companies.edit')->with([
            'company' => $company,
            'managers' => $users->newQuery()->where('role', '=', 'manager')->get()
        ]);
    }

    public function save($id, Request $request, Company $companies){
        $rules = [
            'name' => 'required'
        ];

        if($request->get('image')){
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif';
        }

        $request->validate($rules);

        $company = $companies->newQuery()->with('image')->findOrFail($id);
        $company->fill($request->all());
        $company->save();

        if($request->file('image') && $request->file('image')->isValid()) {
            if($existing_image = $company->getRelation('image')){
                $existing_image->deleteFile();
            }
            $file = new File();
            $file->saveFile('companies', $request->file('image'));
            $company->fill(['image_id' => $file->getAttribute('id')]);
            $company->save();
        }

        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', 'Company details have been saved');
        return redirect()->route('admin.companies.list');
    }

    public function delete($id, Company $companies){
        $company = $companies->newQuery()->with('image')->findOrFail($id);
        try {
            if($image = $company->getRelation('image')){
                $image->deleteFile();
            }
            $company->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return redirect()->route('admin.companies.list');
    }
}
