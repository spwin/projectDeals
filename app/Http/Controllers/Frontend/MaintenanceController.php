<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class MaintenanceController extends Controller
{
    public function maintenance(){
        return view('frontend.pages.maintenance.index');

    }
}
