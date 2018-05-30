<?php

use App\Listing;
use Illuminate\Database\Seeder;

class ListingCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listings = Listing::all();
        foreach($listings as $listing) {
            factory(App\ListingCategory::class)->create([
                'listing_id' => $listing->getAttribute('id')
            ]);
        }
    }
}