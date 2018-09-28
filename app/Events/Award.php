<?php

namespace App\Events;

use App\Listing;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Award
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $listing;
    public $winner;

    /**
     * Create a new event instance.
     *
     * @param Listing $listing
     * @param User $winner
     */
    public function __construct(Listing $listing, User $winner)
    {
        $this->listing = $listing;
        $this->winner = $winner;
    }
}
