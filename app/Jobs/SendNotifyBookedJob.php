<?php

namespace App\Jobs;

use App\Models\Tour\TourBooked;
use App\Models\User;
use App\Notifications\BookedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotifyBookedJob implements ShouldQueue
{
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   public TourBooked $booked;

   public function __construct(TourBooked $booked)
   {
      $this->booked = $booked;
   }

   public function handle()
   {
      User::get()->each(fn($user) => $user->notify(new BookedNotification($this->booked)));
   }
}
