<?php

namespace App\Events;

use App\Listing;
use App\Rotation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProcessListing
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $listing;
    public $rotation;

    /**
     * Create a new event instance.
     *
     * @param Listing $listing
     * @param Rotation $rotation
     */
    public function __construct(Listing $listing, Rotation $rotation)
    {
        $this->listing = $listing;
        $this->rotation = $rotation;
    }
}
