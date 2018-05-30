<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class)->create([
            'name' => 'food & drink',
            'slug' => 'food_and_drink',
            'icon' => 'fa-cutlery',
            'order' => 1
        ]);

        factory(App\Category::class)->create([
            'name' => 'events',
            'slug' => 'events',
            'icon' => 'fa-calendar',
            'order' => 2
        ]);

        factory(App\Category::class)->create([
            'name' => 'beauty',
            'slug' => 'beauty',
            'icon' => 'fa-female',
            'order' => 3
        ]);

        factory(App\Category::class)->create([
            'name' => 'fitness',
            'slug' => 'fitness',
            'icon' => 'fa-bolt',
            'order' => 4
        ]);

        factory(App\Category::class)->create([
            'name' => 'furniture',
            'slug' => 'furniture',
            'icon' => 'fa-image',
            'order' => 5
        ]);

        factory(App\Category::class)->create([
            'name' => 'fashion',
            'slug' => 'fashion',
            'icon' => 'fa-umbrella',
            'order' => 6
        ]);

        factory(App\Category::class)->create([
            'name' => 'shopping',
            'slug' => 'shopping',
            'icon' => 'fa-shopping-cart',
            'order' => 7
        ]);

        factory(App\Category::class)->create([
            'name' => 'home & garden',
            'slug' => 'home_and_garden',
            'icon' => 'fa-home',
            'order' => 8
        ]);

        factory(App\Category::class)->create([
            'name' => 'travel',
            'slug' => 'travel',
            'icon' => 'fa-plane',
            'order' => 9
        ]);
    }
}