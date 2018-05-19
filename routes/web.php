<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

        // Users
        Route::get('/users/{role}', 'UsersController@index')->name('admin.users.list');
        Route::get('/users/{role}/create', 'UsersController@create')->name('admin.users.create');
        Route::post('/users/{role}/add', 'UsersController@add')->name('admin.users.add');
        Route::get('/users/edit/{id}', 'UsersController@edit')->name('admin.users.edit');
        Route::post('/users/save/{id}', 'UsersController@save')->name('admin.users.save');
        Route::get('/users/{role}/delete/{id}', 'UsersController@delete')->name('admin.users.delete');

        // Companies
        Route::get('/companies', 'CompaniesController@index')->name('admin.companies.list');
        Route::get('/companies/create', 'CompaniesController@create')->name('admin.companies.create');
        Route::get('/companies/edit/{id}', 'CompaniesController@edit')->name('admin.companies.edit');
        Route::post('/companies/add', 'CompaniesController@add')->name('admin.companies.add');
        Route::post('/companies/save/{id}', 'CompaniesController@save')->name('admin.companies.save');
        Route::get('/companies/delete/{id}', 'CompaniesController@delete')->name('admin.companies.delete');

        // Deals
        Route::get('/deals', 'DealsController@index')->name('admin.deals.list');
        Route::get('/deals/create', 'DealsController@create')->name('admin.deals.create');
        Route::get('/deals/edit/{id}', 'DealsController@edit')->name('admin.deals.edit');
        Route::post('/deals/add', 'DealsController@add')->name('admin.deals.add');
        Route::post('/deals/save/{id}', 'DealsController@save')->name('admin.deals.save');
        Route::get('/deals/delete/{id}', 'DealsController@delete')->name('admin.deals.delete');
    });

    /*  ==============
        Authentication
        ==============  */
    Route::middleware('role:admin')->group(function () {
        Route::get('/logout', 'Auth\LoginController@logout')->name('admin.logout');
    });
    Route::middleware('not:admin')->group(function() {
        Route::get('/login', 'Auth\LoginController@showLoginForm')->name('admin.login.form');
        Route::post('/login', 'Auth\LoginController@login')->name('admin.login.process');
    });
});

