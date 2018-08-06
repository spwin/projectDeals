<?php

namespace App\Jobs;

use App\Listing;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TestQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $listings;
    protected $listing;

    /**
     * Create a new job instance.
     * @param Listing $listing
     */
    public function __construct(Listing $listing)
    {
        $this->listing = $listing;
    }

    /**
     * Execute the job.
     *
     * @param Listing $listings
     * @return void
     */
    public function handle(Listing $listings)
    {
        $this->listings = $listings;
        for($i = 0; $i < 1000000; $i++){
            $sum = 1 + 1;
        }
        $listing = $this->listings->newQuery()->findOrFail($this->listing->getAttribute('id'));
        $listing->touch();
    }
}
