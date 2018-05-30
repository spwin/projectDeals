<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(){
        return view('frontend.account.index');
    }

    public function showRegisterForm(){
        return view('frontend.auth.register');
    }

    public function register(Request $request){
        $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => ['required','email', Rule::unique('users', 'email')->where(function ($query) {
                return $query->where('role', 'user');
            })],
            'password' => 'required|min:6|confirmed',
            'terms_of_use' => 'required'
        ]);

        $request->merge([
            'password' => Hash::make($request->get('password')),
            'role' => 'user'
        ]);

        $user = new User();
        $user->fill($request->all());
        $user->save();

        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', "Confirmation email has been sent to <b>{$user->getAttribute('email')}</b>.");
        return redirect()->route('user.login.form');
    }
}
