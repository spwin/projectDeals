<?php

namespace App\Listeners;

use App\Coupon;
use App\Events\Award;
use App\Mail\SendCoupon;
use App\Participation;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

    /** @var PDF */
    private $pdf;

    /** @var Coupon */
    private $coupon;

    /**
     * Create the event listener.
     *
     * @param PDF $pdf
     * @param Coupon $coupon
     */
    public function __construct(PDF $pdf, Coupon $coupon)
    {
        $this->pdf = $pdf;
        $this->coupon = $coupon;
    }

    /**
     * Handle the event.
     *
     * @param Award $event
     * @return void
     */
    public function handle(Award $event)
    {
        if (!$event->listing) {
            Log::error('No listing provided to ' . self::class);
            return;
        }

        if (!$event->winner) {
            Log::error('No winner provided to ' . self::class);
            return;
        }

        if (!$event->rotation) {
            Log::error('No rotation provided to ' . self::class);
            return;
        }

        Log::info('Winner: ' . $event->winner->getAttribute('email'));

        // Generate and send coupons
        $couponCode = randomString(12);
        $pdf = $this->pdf->loadView('pdf.coupons.winner', [
            'listing' => $event->listing,
            'user' => $event->winner,
            'coupon' => $couponCode
        ]);

        $now = Carbon::now();

        $this->coupon->newQuery()->insert([
            'code' => $couponCode,
            // TODO: get from database
            'valid_until' => date('Y-m-d H:i:s', strtotime('+1 year', time())),
            'company_id' => $event->listing->getRelation('company')->getAttribute('id'),
            'user_id' => $event->winner->getAttribute('id'),
            'deal_id' => $event->listing->getRelation('deal')->getAttribute('id'),
            'listing_id' => $event->listing->getAttribute('id'),
            'rotation_id' => $event->rotation->getAttribute('id'),
            'created_at' => $now,
            'updated_at' => $now
        ]);
        // $this->sendMail($event, $pdf, $couponCode);
    }

    private function sendMail($event, $pdf, $couponCode){
        Mail::to($event->winner->getAttribute('email'))
            ->send(new SendCoupon($event->listing, $event->winner, $pdf->output(), $couponCode));
    }

}
