<?php

use Illuminate\Support\Facades\Auth;

function currentUser($guard, $field = null){
    if($field){
        return Auth::guard($guard)->user()->getAttribute($field);
    }
    return Auth::guard($guard)->user();
}

function admin($field = null){
    return currentUser('admin', $field);
}

function manager($field = null){
    return currentUser('manager', $field);
}

function rewards(){
    return [
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'instagram' => 'Instagram',
        'pinterest' => 'Pinterest'
    ];
}