<?php

namespace App\Http\Controllers\Manager\Auth;

use App\Http\Controllers\BaseLoginController;

class LoginController extends BaseLoginController
{
    protected $role = 'manager';
    protected $redirectTo = '/';
    protected $loginPath = '/login';
    protected $loginView = 'manager.auth.login';
    protected $redirectToPrevious = false;
}
