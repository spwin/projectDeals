<?php

namespace App\Mail;

use App\Listing;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCoupon extends Mailable
{
    use Queueable, SerializesModels;

    protected $listing;
    protected $coupon;
    protected $user;
    protected $pdf;

    /**
     * Create a new message instance.
     *
     * @param Listing $listing
     * @param User $user
     * @param string $pdf
     * @param string $coupon
     */
    public function __construct(Listing $listing, User $user, string $pdf, string $coupon)
    {
        $this->listing = $listing;
        $this->user = $user;
        $this->coupon = $coupon;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('frontend.email.coupons.winner')
                    ->subject('🎉 You have won a contest this week!')
                    ->with([
                        'listing' => $this->listing,
                        'user' => $this->user,
                        'coupon' => $this->coupon
                    ])
                    ->attachData($this->pdf, 'coupon.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
