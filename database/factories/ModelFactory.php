<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Company;
use App\Deal;
use App\File;
use App\Listing;
use App\User;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    $return = [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'role' => 'user',
        'remember_token' => str_random(10),
    ];

    if($image = randomImg('assets/img/demo_avatars')){
        $image_file = new File();
        $image_file->saveFile('users', $image);
        $return['image_id'] = $image_file->getAttribute('id');
    }

    return $return;
});


$factory->define(App\Company::class, function (Faker\Generator $faker) {
    $users = User::where(['role' => 'manager'])->get();
    $return = [
        'name' => $faker->company,
        'slug' => $faker->slug,
        'phone' => $faker->phoneNumber,
        'email' => $faker->companyEmail,
        'website' => $faker->url,
        'rating' => rand(100, 500) / 100,
        'description' => $faker->paragraph,
        'user_id' => $users->random(),
        'social' => collect([
            'facebook' => $faker->url,
            'twitter' => $faker->url,
            'instagram' => $faker->url,
            'pinterest' => $faker->url,
            'google' => $faker->url
        ]),
        'seo' => collect([
            'title' => implode(' ',$faker->words(6)),
            'description' => $faker->sentence,
            'keywords' => implode(',',$faker->words(6))
        ])
    ];

    if($image = randomImg('assets/img/demo_logos')){
        $image_file = new File();
        $image_file->saveFile('companies', $image);
        $return['image_id'] = $image_file->getAttribute('id');
    }

    return $return;
});

$factory->define(App\Deal::class, function (Faker\Generator $faker) {
    $companies = Company::all();

    $return = [
        'company_id' => $companies->random(),
        'name' => $faker->sentence,
        'slug' => $faker->slug,
        'description' => $faker->paragraphs(4, true),
        'terms_and_conditions' => $faker->paragraphs(4, true),
        'price' => rand(0, 500),
        'link' => $faker->url,
        'rating' => rand(100, 500) / 100,
        'status' => rand(0, 1),
        'seo' => collect([
            'title' => implode(' ',$faker->words(6)),
            'description' => $faker->sentence,
            'keywords' => implode(',',$faker->words(6))
        ]),
        'location' => collect([
            'lon' => $faker->longitude,
            'lat' => $faker->latitude
        ])
    ];

    if($image = randomImg()){
        $image_file = new File();
        $image_file->saveFile('deals', $image);
        $return['image_id'] = $image_file->getAttribute('id');
    }

    return $return;
});

$factory->define(App\Category::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'slug' => $faker->slug,
        'icon' => 'fa-ticket'
    ];
});

$factory->define(App\Listing::class, function (Faker\Generator $faker) {
    $deals = Deal::all();
    $status = rand(0, 4);
    $weeks = rand(1, 10);

    $friyayTime = friyayTime();
    if($status == 3){
        $startsAt = addWeeks($friyayTime, -1);
        $endsAt = $friyayTime;
    } elseif($status == 4){
        $startsAt = addWeeks($friyayTime, rand(-7, -2));
        $endsAt = addWeeks($startsAt, 1);
    } else {
        $startsAt = addWeeks($friyayTime, rand(0,3));
        $endsAt = addWeeks($startsAt, $weeks);
    }

    $return = [
        'deal_id' => $deals->random(),
        'weeks' => $weeks,
        'passed' => rand(0, 1),
        'coupons_count' => rand(1, 100),
        'starts_at' => date('Y-m-d H:i:s', $startsAt),
        'ends_at' => date('Y-m-d H:i:s', $endsAt),
        'valid' => $status == 3 ? 1 : 0,
        'views' => rand(0, 2000000),
        'status' => $status,
        'best_deals' => booleanRandom(3),
        'category_featured' => booleanRandom(3),
        'follow_link' => booleanRandom(3),
        'newsletter' => booleanRandom(3),
    ];

    $slider_image = booleanRandom(3);
    if($slider_image && $image = randomImg()){
        $slider_image_file = new File();
        $slider_image_file->saveFile('listings_sliders', $image);
        $return['slider_image'] = 1;
        $return['slider_image_id'] = $slider_image_file->getAttribute('id');
    }

    $menu_image = booleanRandom(3);
    if($menu_image && $image = randomImg()){
        $menu_image_file = new File();
        $menu_image_file->saveFile('listings_menu', $image);
        $return['menu_image'] = 1;
        $return['menu_image_id'] = $menu_image_file->getAttribute('id');
    }

    return $return;
});

$factory->define(App\ListingCategory::class, function(Faker\Generator $faker) {
    $listings = Listing::all();
    $categories = Category::all();
    return [
        'listing_id' => $listings->random(),
        'category_id' => $categories->random()
    ];
});