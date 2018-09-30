<?php

namespace App\Events;

use App\Listing;
use App\Rotation;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Award
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $listing;
    public $winner;
    public $rotation;

    /**
     * Create a new event instance.
     *
     * @param Listing $listing
     * @param User $winner
     * @param Rotation $rotation
     */
    public function __construct(Listing $listing, User $winner, Rotation $rotation)
    {
        $this->listing = $listing;
        $this->winner = $winner;
        $this->rotation = $rotation;
    }
}
