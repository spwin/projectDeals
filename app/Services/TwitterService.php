<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Listing;
use Thujohn\Twitter\Twitter;

class TwitterService extends Controller
{
    private $twitter;

    public function __construct(Twitter $twitter){
        $this->twitter = $twitter;
    }

    public function publish(Listing $listing): string {
        $link = route('listing', ['id' => $listing->getAttribute('id'), 'slug' => $listing->getRelation('deal')->getAttribute('slug')]);
        $message = substr($listing->getRelation('deal')->getAttribute('name'), 0, 119).' '.$link;

        $response = $this->twitter->postTweet([
            'status' => $message,
            'format' => 'object'
        ]);

        return $response->id_str ?: null;
    }
}
