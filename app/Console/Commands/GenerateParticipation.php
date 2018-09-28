<?php

namespace App\Console\Commands;

use App\Listing;
use App\Participation;
use App\Rotation;
use App\User;
use Illuminate\Console\Command;

class GenerateParticipation extends Command
{
    protected $listings;
    protected $rotation;

    protected $job;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'participation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate random participations among current users and listings';

    /**
     * Create a new command instance.
     *
     * @param Listing $listings
     * @param Rotation $rotation
     */
    public function __construct(Listing $listings, Rotation $rotation)
    {
        $this->listings = $listings;
        $this->rotation = $rotation;

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $currentRotation = $this->rotation->newQuery()->where(['active' => true])->first();

        $liveListings = $this->listings->newQuery()->where(['valid' => true])->get();

        $users = new User();
        $participants = $users->newQuery()->inRandomOrder()->where(['confirmed' => true])->get();

        foreach($participants as $participant){
            foreach($liveListings->random(10) as $listing) {
                $participation = new Participation();
                $participation->fill([
                    'user_id' => $participant->id,
                    'listing_id' => $listing->id,
                    'rotation_id' => $currentRotation->id
                ]);
                $participation->save();
            }
        }
    }
}
