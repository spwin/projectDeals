<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Listing;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

class FacebookService extends Controller
{

    private $fb;
    private $pageID;

    public function __construct(){
        $this->pageID = config('services.facebook.page_id');
        try {
            $this->fb = new Facebook([
                'app_id' => config('services.facebook.client_id'),
                'app_secret' => config('services.facebook.client_secret'),
                'default_graph_version' => config('services.facebook.graph_version')
            ]);
            $this->fb->setDefaultAccessToken(
                config('services.facebook.access_token')
                // $this->fb->getApp()->getAccessToken()
            );
        } catch (FacebookSDKException $e) {
            report($e);
        }
    }

    public function publish(Listing $listing): string {
        try {
            $response = $this->fb->post("/{$this->pageID}/feed/", [
                'message' => $listing->getRelation('deal')->getAttribute('description'),
                'link' => route('listing', ['id' => $listing->getAttribute('id'), 'slug' => $listing->getRelation('deal')->getAttribute('slug')]),
            ], $this->fb->getDefaultAccessToken());
        } catch(FacebookResponseException $e) {
            echo $e->getMessage();
            report($e);
            exit;
        } catch(FacebookSDKException $e) {
            echo $e->getMessage();
            report($e);
            exit;
        }
        $body = collect($response->getDecodedBody());
        $postID = $body->get('id');
        if($postID){
            return $postID;
        }
        exit;
    }
}
