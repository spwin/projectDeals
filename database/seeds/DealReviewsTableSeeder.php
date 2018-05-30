<?php

use App\Deal;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DealReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::with('reviews')->get();
        $deals = Deal::all();
        foreach($users as $user) {
            foreach($deals->random(50) as $deal){
                $user->reviews()->attach($deal->getAttribute('id'), [
                    'date' => date('Y-m-d H:i:s', time()),
                    'rating' => rand(1,5),
                    'review' => $faker->paragraph
                ]);
            }
        }
    }
}