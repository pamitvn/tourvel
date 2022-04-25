<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ContactMail extends Mailable implements ShouldQueue
{
   use Queueable, SerializesModels;

   protected Collection $data;

   public function __construct($data = [])
   {
      $this->data = collect($data);
   }

   public function subject($subject)
   {
      return nova_get_setting('smtp_from_name', 'The Best Tour') . " - yêu cầu liên hệ từ {$this->data['fullName']}";
   }

   public function build()
   {
      return $this->from($this->data->get('email', nova_get_setting('smtp_from_address')))->markdown('emails.contact')->with('data', $this->data);
   }
}
