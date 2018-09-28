<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $google2fa = app('pragmarx.google2fa');
        $secretKey = $google2fa->generateSecretKey();

        $request->merge([
            'password' => Hash::make($request->get('password')),
            'google2fa_secret' => $secretKey,
            'role' => 'user'
        ]);

        $user = new User();
        $user->fill($request->all());
        $user->save();

        $request->session()->flash('message-type', 'success');
        $request->session()->flash('message', "Confirmation email has been sent to <b>{$user->getAttribute('email')}</b>.");
        return redirect()->route('user.login.form');
    }

    public function twoFactorLogin(Request $request){
        if($user = $request->user('user')){
            $google2fa = app('pragmarx.google2fa');

            $google2fa->setAllowInsecureCallToGoogleApis(true);

            $google2fa_url = $google2fa->getQRCodeGoogleUrl(
                config('app.name'),
                $user->email,
                $user->google2fa_secret
            );

            return view('frontend.auth.qr', ['QR_Image' => $google2fa_url, 'secret' => $user->google2fa_secret]);
        }
        return abort(403);
    }

    public function twoFactorProcess(Request $request){
        if($user = $request->user('user')) {
            $request->validate([
                'secret' => 'required|min:6|max:6'
            ]);

            $google2fa = app('pragmarx.google2fa');

            $secret = $request->input('secret');
            $timestamp = $google2fa->verifyKeyNewer($user->google2fa_secret, $secret, $user->google2fa_ts);

            if ($timestamp !== false) {
                $user->update(['google2fa_ts' => $timestamp]);
                session()->put('2fa_auth_'.$timestamp, salt2fa($user));
                return redirect()->route('user');
            } else {
                $request->session()->flash('message-type', 'danger');
                $request->session()->flash('message', "Invalid secret key.");
                return redirect()->back();
            }
        }
    }
}
