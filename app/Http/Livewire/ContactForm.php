<?php

namespace App\Http\Livewire;

use App\Jobs\SendContactMailJob;
use Livewire\Component;

class ContactForm extends Component
{
   public string $fullName = '';
   public string $email = '';
   public ?string $phoneNumber = '';
   public ?string $address = '';
   public string $content = '';

   protected array $rules = [
      'fullName' => 'required|max:150',
      'email' => 'required|email|max:255',
      'content' => 'required'
   ];

   public function updated($propertyName)
   {
      session()->forget('success');
      $this->validateOnly($propertyName);
   }

   public function render()
   {
      return view('livewire.contact-form');
   }

   public function handleFormSubmit()
   {
      $data = $this->validate();

      dispatch(new SendContactMailJob($data));

      session()->flash('success', 'Thông tin liên hệ của bạn đã được ghi nhận và sẽ phản hồi lại trong thời gian sớm nhất.');

      $this->resetForm();
   }

   private function resetForm()
   {
      $this->fullName = '';
      $this->email = '';
      $this->phoneNumber = '';
      $this->address = '';
      $this->content = '';

      $this->resetValidation();
   }
}
