<?php

namespace App\Listeners;

use App\Events\Publish;
use App\Services\FacebookService;
use App\Services\TwitterService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class PublishListener implements ShouldQueue
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

    private $twitter;

    /**
     * Create the event listener.
     *
     * @param TwitterService $twitter
     */
    public function __construct(TwitterService $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * Handle the event.
     *
     * @param  Publish  $event
     * @return void
     */
    public function handle(Publish $event)
    {
        if(!$event->listing){
            Log::error('No listing provided to PublishListener');
            return;
        }


        //$fb = new FacebookService();
        //$fbPostID = $fb->publish($event->listing);
        //$event->listing->update(['facebook_id' => $fbPostID]);
        //$tweeterPostID = $this->twitter->publish($event->listing);
        //$event->listing->update(['twitter_id' => $tweeterPostID]);

    }
}
