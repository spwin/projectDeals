<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class BaseLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $role;
    protected $redirectTo;
    protected $loginPath;
    protected $loginView;
    protected $redirectToPrevious;

    protected function guard()
    {
        return auth()->guard($this->role);
    }

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('not:'.$this->role)->except('logout');
    }

    protected function authenticated(Request $request, User $user){

    }

    public function showLoginForm()
    {
        return view($this->loginView);
    }

    public function login(Request $request)
    {
        if($url  = $request->get('url')){
            $this->redirectTo = $url;
        } elseif($this->redirectToPrevious){
            $this->redirectTo = url()->previous();
        }

        if($validator = $this->validateLogin($request)){
            if($validator->fails()) {
                return redirect($this->loginPath)
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $role = $this->role;
        $validator = Validator::make($request->all(), [
            $this->username() => ['required', 'string',
                Rule::exists('users')->where(function ($query) use ($role) {
                    return $query->where('role', $role);
                })],
            'password' => ['required', 'string']
        ]);

        return $validator;
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect($this->loginPath);
    }
}
