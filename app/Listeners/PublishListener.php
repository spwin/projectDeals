<?php

namespace App\Listeners;

use App\Events\Publish;
use App\Services\FacebookService;
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

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        // $fb = new FacebookService();
        // $postID = $fb->publish($event->listing);
        $postID = 1;
        $event->listing->update(['facebook_id' => $postID]);
    }
}
