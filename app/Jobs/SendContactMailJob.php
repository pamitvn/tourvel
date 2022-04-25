<?php

namespace App\Jobs;

use App\Mail\ContactMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendContactMailJob implements ShouldQueue
{
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   protected array $data;

   public function __construct($data = [])
   {
      $this->data = $data;
   }

   public function handle()
   {
      $email = new ContactMail($this->data);

      Mail::to(nova_get_setting('page_contact_mail_to', nova_get_setting('contact_mail')))->send($email);
   }
}
