<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\BaseLoginController;

class LoginController extends BaseLoginController
{
    protected $role = 'admin';
    protected $redirectTo = '/admin';
    protected $loginPath = '/admin/login';
    protected $loginView = 'admin.auth.login';
    protected $redirectToPrevious = false;
}
