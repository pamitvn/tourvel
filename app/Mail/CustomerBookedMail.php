<?php

namespace App\Mail;

use App\Models\Tour\TourBooked;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerBookedMail extends Mailable implements ShouldQueue
{
   use Queueable, SerializesModels;

   public TourBooked $booked;

   public function __construct(TourBooked $booked)
   {
      $this->booked = $booked;
   }

   public function build(): self
   {
      $from = nova_get_setting('smtp_from_address');
      $name = nova_get_setting('smtp_from_name');

      return $this->subject('Xác nhận đã đăng ký tour tại ' . config('app.name'))
         ->from($from, $name)
         ->markdown('emails.customers.booked')
         ->with('booked', $this->booked);
   }
}
