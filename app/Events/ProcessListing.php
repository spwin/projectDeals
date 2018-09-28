<?php

namespace App\Events;

use App\Listing;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProcessListing
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $listing;
    public $winner;

    /**
     * Create a new event instance.
     *
     * @param Listing $listing
     */
    public function __construct(Listing $listing)
    {
        $this->listing = $listing;
    }
}
