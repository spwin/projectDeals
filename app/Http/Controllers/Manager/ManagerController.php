<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;

class ManagerController extends Controller
{
    public function dashboard(){
        return view('manager.dashboard');
    }
}
