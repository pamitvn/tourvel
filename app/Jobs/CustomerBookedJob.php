<?php

namespace App\Jobs;

use App\Mail\CustomerBookedMail;
use App\Models\Tour\TourBooked;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CustomerBookedJob implements ShouldQueue
{
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   public TourBooked $booked;

   public function __construct(TourBooked $booked)
   {
      $this->booked = $booked;
   }

   public function handle()
   {
      $email = new CustomerBookedMail($this->booked);

      Mail::to($this->booked->customer->email)->send($email);
   }
}
