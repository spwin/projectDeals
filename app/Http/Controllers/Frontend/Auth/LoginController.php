<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\BaseLoginController;

class LoginController extends BaseLoginController
{
    protected $role = 'user';
    protected $redirectTo = '/user';
    protected $loginPath = '/login';
    protected $loginView = 'frontend.auth.login';
    protected $redirectToPrevious = true;

}
