<?php

namespace App\Notifications;

use App\Models\Tour\TourBooked;
use App\Nova\Resources\Tours\Booked\BookedResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Nova\Notifications\NovaChannel;
use Laravel\Nova\Notifications\NovaNotification;
use Laravel\Nova\URL;

class BookedNotification extends Notification implements ShouldQueue
{
   use Queueable;

   protected TourBooked $booked;
   protected string $booked_detail;

   public function __construct(TourBooked $booked)
   {
      $this->booked = $booked;
      $this->booked_detail = get_nova_url('resources/' . BookedResource::uriKey() . '/' . $this->booked->id);
   }

   public function via($notifiable): array
   {
      return [
         'mail',
         NovaChannel::class
      ];
   }

   public function toMail($notifiable): MailMessage
   {
      return (new MailMessage)
         ->subject(config('app.name') . ' ' . $this->booked->property->tour->name . ' - Có người đăng ký mới')
         ->action('Chi tiết', $this->booked_detail);
   }

   public function toNova($notifiable): NovaNotification
   {
      return (new NovaNotification)
         ->message("New booked #{$this->booked->id}")
         ->url('resources/' . BookedResource::uriKey() . '/' . $this->booked->id)
         ->icon('book-open')
         ->type('success');
   }
}
