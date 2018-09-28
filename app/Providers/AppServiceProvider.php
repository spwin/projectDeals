<?php

namespace App\Providers;

use App\Listing;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        date_default_timezone_set(env('APP_TIMEZONE'));

        try {
            if (Schema::hasTable('listings')) {
                $liveListings = Listing::with('sliderImage', 'menuImage', 'deal', 'deal.image', 'deal.company', 'deal.reviews')
                    ->where(['valid' => true])->get();

                view()->share('liveListings', $liveListings);
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
