<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    private $paginate = 20;

    public function index($role, User $user, Request $request){
        $users = $user->newQuery()->where('role', $role);
        if($search = $request->get('q')){
            $users->where('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
        }
        $users = $users->orderByDesc('id')->paginate($this->paginate);

        return view('admin.pages.users.list')->with([
            'users' => $users,
            'role' => $role
        ]);
    }

    public function edit($id, User $users){
        $user = $users->newQuery()->with('image')->findOrFail($id);
        return view('admin.pages.users.edit')->with([
            'user' => $user
        ]);
    }

    public function create($role){
        return view('admin.pages.users.create')->with([
            'role' => $role
        ]);
    }

    public function add($role, Request $request){
        $request->validate([
            'first_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $request->request->add(['role' => $role]);

        $user = new User();
        $user->fill($request->all());
        $user->save();

        if($request->file('image') && $request->file('image')->isValid()) {
            $file = new File();
            $file->saveFile('users', $request->file('image'));
            $user->fill(['image_id' => $file->getAttribute('id')]);
            $user->save();
        }

        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', 'User has been created');
        return redirect()->route('admin.users.list', ['role' => $role]);
    }

    public function save($id, Request $request, User $users){
        $rules = [
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id
        ];

        if($request->get('password')){
            $rules['password'] = 'confirmed|min:6';
        } else {
            $request->request->remove('password');
            $request->request->remove('password_confirmation');
        }

        if($request->get('image')){
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif';
        }

        $request->validate($rules);

        $user = $users->newQuery()->with('image')->findOrFail($id);
        $user->fill($request->all());
        $user->save();

        if($request->file('image') && $request->file('image')->isValid()) {
            if($existing_image = $user->getRelation('image')){
                $existing_image->deleteFile();
            }
            $file = new File();
            $file->saveFile('users', $request->file('image'));
            $user->fill(['image_id' => $file->getAttribute('id')]);
            $user->save();
        }

        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', 'User details have been saved');
        return redirect()->back();
    }

    public function delete($role, $id, User $users){
        $user = $users->newQuery()->with('image')->findOrFail($id);
        try {
            if($image = $user->getRelation('image')){
                $image->deleteFile();
            }
            $user->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return redirect()->route('admin.users.list', ['role' => $role]);
    }
}
