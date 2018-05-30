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

Route::domain(env('BACKEND_DOMAIN'))->group(function(){
    Route::namespace('Manager')->group(function () {
        Route::get('/', function(){
            echo 'Manager login';
        });
    });

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

            // Listings
            Route::get('/listings', 'ListingsController@index')->name('admin.listings.list');
            Route::get('/listings/create', 'ListingsController@create')->name('admin.listings.create');
            Route::get('/listings/edit/{id}', 'ListingsController@edit')->name('admin.listings.edit');
            Route::post('/listings/add', 'ListingsController@add')->name('admin.listings.add');
            Route::post('/listings/save/{id}', 'ListingsController@save')->name('admin.listings.save');
            Route::get('/listings/delete/{id}', 'ListingsController@delete')->name('admin.listings.delete');
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
});

Route::namespace('Frontend')->domain(env('FRONTEND_DOMAIN'))->group(function(){
    Route::get('/', 'FrontendController@homepage')->name('homepage');

    Route::get('/listings/{id}/{slug}', 'ListingController@index')->name('listing');
    Route::get('/company/{id}/{slug}', 'CompanyController@view')->name('company');

    // Rating
    Route::post('/listing/{id}/rate', 'DealController@rate')->name('deal.rate');

    // User
    Route::get('/user', 'UserController@index')->name('user');

    // Socialite
    Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.login');
    Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');

    Route::middleware('role:user')->group(function () {
        Route::get('/logout', 'Auth\LoginController@logout')->name('user.logout');
    });
    Route::middleware('not:user')->group(function() {
        Route::get('/register', 'UserController@showRegisterForm')->name('user.register.form');
        Route::post('/register', 'UserController@register')->name('user.register.process');

        Route::get('/login', 'Auth\LoginController@showLoginForm')->name('user.login.form');
        Route::post('/login', 'Auth\LoginController@login')->name('user.login.process');
    });

    Route::get('/{view}', 'FrontendController@static')->name('static');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
