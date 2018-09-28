<?php

namespace App\Console\Commands;

use App\Enums\ListingStatus;
use App\Events\Award;
use App\Events\ProcessListing;
use App\Events\Publish;
use App\Listing;
use App\Participation;
use App\ParticipationArchive;
use App\Rotation;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Friyay extends Command
{
    protected $test = true;
    protected $listings;
    protected $award;
    protected $current;
    protected $rotation;
    protected $participation;

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
     * @param Rotation $rotation
     * @param Participation $participation
     */
    public function __construct(Listing $listings, Rotation $rotation, Participation $participation)
    {
        $this->listings = $listings;
        $this->award = collect([]);
        $this->current = collect([]);
        $this->rotation = $rotation;
        $this->participation = $participation;

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // dapalnitelna paslauga zostawic firma bez live listingu
        // jezeli zauwazono ze user w systemie ma wiecej niz 3 soc acc to on popada do listy padazrenija
        $this->test = $this->option('test');

        $time_start = microtime(true);

        $result = DB::transaction(function () {

            // Create new week rotation
            $this->newRotation();
            // Disable expired listings and update/enable new ones
            $this->rotateListings();
        }, 5);

        if(is_null($result)) {
            // Auto generate posts on social pages and announce the deals for all
            foreach ($this->current as $listing) {
                event(new Publish($listing));
            }

            // Set current participation to be sent to archive
            $this->archiveParticipation();

            // Change images on social pages to expired (red corner badge)
            // Randomly select the winners
            // Generate coupons
            foreach ($this->award as $listing) {
                event(new ProcessListing($listing));
            }
        } else {
            report(new \Exception());
        }

        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start);
        $this->info("Execution time: " . $execution_time . "s\n");
        $this->info("Listing to award: " . count($this->award) . "");
        $this->info("Listing this week: " . count($this->current) . "\n");

        // QUEUE THESE:

        // Generate manager reports
        // Send emails for managers with stats
    }

    private function archiveParticipation(){
        $this->participation->newQuery()->update(['archive' => true]);
    }

    private function newRotation(){
        $now = Carbon::now();
        $this->rotation->newQuery()->where(['active' => true])->update(['active' => false, 'ended_at' => $now]);

        $newRotation = new Rotation();
        $newRotation->fill(['started_at' => $now])->save();
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
        return $this->listings->newQuery()->with('deal', 'participants')->where(['valid' => true])->get();
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
            'status' => ListingStatus::ENDED,
            'valid' => false
        ]);
    }

    private function enableNewListings(){
        if($this->option('test')){
            $this->listings->newQuery()
                ->where('status', '=', ListingStatus::APPROVED)
                ->whereDate('starts_at', '>', date('Y-m-d H:i:s', strtotime('- 1 day')))
                ->whereDate('starts_at', '<', date('Y-m-d H:i:s', strtotime('+ 1 week')))
                ->update([
                    'status' => ListingStatus::LIVE,
                    'valid' => true
                ]);
        } else {
            $this->listings->newQuery()
                ->where('status', '=', ListingStatus::APPROVED)
                ->whereDate('starts_at', '>', date('Y-m-d H:i:s', strtotime('- 1 day')))
                ->whereDate('starts_at', '<', date('Y-m-d H:i:s', strtotime('+ 1 day')))
                ->update([
                    'status' => ListingStatus::LIVE,
                    'valid' => true
                ]);
        }
    }
}
