<?php

use App\Listing;
use App\User;
use Illuminate\Database\Seeder;

class ParticipationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listings = new Listing();
        $liveListings = $listings->newQuery()->where(['valid' => true])->get();

        $users = new User();
        $activeUsers = $users->newQuery()->where(['confirmed' => true])->get();

        foreach($liveListings as $listing) {
            $participants = $activeUsers->random(rand(0, $activeUsers->count()));

            foreach($participants as $participant){
                factory(App\Participation::class)->create([
                    'listing_id' => $listing->getAttribute('id'),
                    'user_id' => $participant->getAttribute('id')
                ]);
            }
        }
    }
}
