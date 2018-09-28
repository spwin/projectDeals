<?php

namespace App\Listeners;

use App\Events\Award;
use App\Participation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class AwardListener implements ShouldQueue
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
    public $queue = 'award';

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
     * @param Award $event
     * @return void
     */
    public function handle(Award $event)
    {
        if(!$event->listing){
            Log::error('No listing provided to ' . self::class);
            return;
        }

        if(!$event->winner){
            Log::error('No winner provided to ' . self::class);
            return;
        }

        Log::info('Winner: ' . $event->winner->getAttribute('email'));

        // Generate coupon and send email
    }
}
