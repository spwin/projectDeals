<?php

namespace App\Listeners;

use App\Events\Award;
use App\Events\ProcessListing;
use App\Listing;
use App\Participation;
use App\ParticipationArchive;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ProcessListingListener implements ShouldQueue
{
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'redis';

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'publish';

    private $archive;
    private $participation;

    /**
     * Create the event listener.
     *
     * @param ParticipationArchive $archive
     * @param Participation $participation
     */
    public function __construct(ParticipationArchive $archive, Participation $participation)
    {
        $this->archive = $archive;
        $this->participation = $participation;
    }

    /**
     * Handle the event.
     *
     * @param ProcessListing $event
     * @return void
     */
    public function handle(ProcessListing $event)
    {
        if(!$event->listing){
            Log::error('No listing provided to PublishListener');
            return;
        }

        $winners = $this->getWinners($event->listing);

        // Set winner in database
        $this->participation->newQuery()->whereIn('user_id', $winners->pluck('id'))->update(['winner' => true]);
        foreach ($winners as $winner) {
            event(new Award($event->listing, $winner));
        }

        $participationToArchive = $this->participation->newQuery()
            ->select('winner', 'user_id', 'listing_id', 'rotation_id', 'created_at', 'updated_at')
            ->where(['listing_id' => $event->listing->getAttribute('id')])->get();
        $this->archive->newQuery()->insert($participationToArchive->toArray());
        $this->participation->newQuery()->where('listing_id', $event->listing->getAttribute('id'))->delete();
    }

    private function getWinners(Listing $listing){
        $winners = collect([]);

        // Randomly select winners
        $totalWinners = $listing->getAttribute('coupons_count');
        $participants = ($temp = $listing->participants(true)) ? $temp->get() : collect([]);

        Log::info('participants: '.$participants->count());

        // If there is at least one participant
        if($participants->count() > 0) {

            // If participants count < coupons
            if ($totalWinners > $participants->count()) {
                $totalWinners = $participants->count();
            }

            $winners = $participants->random($totalWinners);
        }

        return $winners ?: collect([]);
    }
}
