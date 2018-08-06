<?php

namespace App\Console\Commands;

use App\Jobs\TestQueue;
use App\Listing;
use App\User;
use Illuminate\Console\Command;

class Friyay extends Command
{
    protected $test = true;
    protected $listings;
    protected $award;
    protected $current;

    protected $job;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'friyay {--test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to disable expired listings, enable pending listings, reward winners and run all the robots';

    /**
     * Create a new command instance.
     *
     * @param Listing $listings
     */
    public function __construct(Listing $listings)
    {
        $this->listings = $listings;
        $this->award = collect([]);
        $this->current = collect([]);

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // dapalnitelna paslauga zostawic firma bez live listingu
        // jezeli zauwazono ze user w systemie ma wiecej niz 3 soc acc to on popada do listy padazrenija
        $this->test = $this->option('test');

        $time_start = microtime(true);


        $listings = Listing::all();
        foreach($listings as $listing) {
            TestQueue::dispatch($listing);
        }
        //$this->rotateListings();


        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start);
        $this->info("Execution time: " . $execution_time . "s\n");
        $this->info("Listing to award: " . count($this->award) . "");
        $this->info("Listing this week: " . count($this->current) . "\n");

        // + Deduct weeks - 1 and change status to 4, valid to false if weeks = 0
        // + Get all pending and change status to live, valid to true

        // QUEUE THESE:

        // Change images on social pages to expired (red corner badge)

        // Auto generate posts on social pages and announce the deals for all

        // Scrape all participants from all the websites
        // Randomly select the winners
        // Generate coupons
        // Generate manager reports
        // Send emails for managers with stats
        // Send links for winners
        // Send message to participants
        // Send emails if user already registered with us
    }

    private function rotateListings(){
        // Get all live listings
        $this->award = $this->getLiveListings();

        // Decrement weeks for live listings
        $this->decrementWeeksForLiveListings();

        // Change status to expired if live listing weeks count is 0
        $this->changeStatusToExpired();

        // Enable new listings
        $this->enableNewListings();

        $this->current = $this->getLiveListings();
    }

    private function getLiveListings(){
        return $this->listings->newQuery()->where(['valid' => true])->get();
    }

    private function decrementWeeksForLiveListings(){
        $this->listings->newQuery()->where([
            'valid' => true
        ])->decrement('weeks', 1);
    }

    private function changeStatusToExpired(){
        $this->listings->newQuery()->where([
            'valid' => true,
            'weeks' => 0
        ])->update([
            'status' => 4,
            'valid' => false
        ]);
    }

    private function enableNewListings(){
        if($this->option('test')){
            $this->listings->newQuery()
                ->where('status', 2)
                ->whereDate('starts_at', '>', date('Y-m-d H:i:s', strtotime('- 1 day')))
                ->whereDate('starts_at', '<', date('Y-m-d H:i:s', strtotime('+ 1 week')))
                ->update([
                    'status' => 3,
                    'valid' => true
                ]);
        } else {
            $this->listings->newQuery()
                ->where('status', 2)
                ->whereDate('starts_at', '>', date('Y-m-d H:i:s', strtotime('- 1 day')))
                ->whereDate('starts_at', '<', date('Y-m-d H:i:s', strtotime('+ 1 day')))
                ->update([
                    'status' => 3,
                    'valid' => true
                ]);
        }
    }
}
