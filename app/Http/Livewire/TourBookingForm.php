<?php

namespace App\Http\Livewire;

use App\Enums\TourStatusEnum;
use App\Jobs\CustomerBookedJob;
use App\Jobs\SendNotifyBookedJob;
use App\Models\Customer;
use App\Models\Tour;
use App\Notifications\BookedNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use JetBrains\PhpStorm\ArrayShape;
use Livewire\Component;

class TourBookingForm extends Component
{
   public Collection|Tour $tour;
   public Collection|Tour\TourProperties $property;

   public string $fullName = '';
   public string $phoneNumber = '';
   public string $email = '';
   public ?string $note = null;
   public ?string $startedDate = null;
   public array $amounts = [];

   protected array $rules = [
      'fullName' => 'required|string|max:150',
      'phoneNumber' => 'required|string|min:10|max:11',
      'email' => 'required|email|max:150',
      'note' => 'nullable',
      'startedDate' => 'nullable|date',
      'amounts.*' => 'bail|numeric|gt:0'
   ];

   public function mount(Tour $tour, Tour\TourProperties $property)
   {
      $this->tour = $tour;
      $this->property = $property;
   }

   public function updated($propertyName)
   {
      session()->forget('success');
      $this->validateOnly($propertyName);
   }

   public function render(): Factory|View|Application
   {
      return view('livewire.tour-booking-form');
   }

   public function getTotalProperty(): array
   {
      $collect = collect($this->amounts)->filter(fn($val) => $val !== '');

      return [
         'customers' => $collect->sum(),
         'prices' => $this->handleSumPrice($collect)
      ];
   }

   public function handleSubmitForm()
   {
      session()->forget('success');

      $ids = new Collection([]);

      try {
         $validatedData = $this->validate();
         $total = $this->getTotalProperty();
         $property = Tour\TourProperties::find($this->property->id);

         if ($total['customers'] <= 0) {
            foreach ($this->property->prices->filter(fn($val) => Arr::get($this->amounts, strval($val->id), '') === '') as $item) {
               $this->addError('amounts.' . $item->id, 'Vui lòng nhập số lượng người sẽ đi');
            }
            return;
         }

         if ($property->seat_available !== -1 && $property->seat_available < $property->amount) {
            $this->addError('amount', 'Không còn chỗ trống');

            return;
         }

         if ($property->seat_available !== -1 && $property->seat_available >= $property->amount && $property->status === TourStatusEnum::Seats)) {
               $property->update([
                  'status' => TourStatusEnum::SeatsFull
               ]);
         }

         $customer = Customer::wherePhoneNumber($validatedData['phoneNumber'])
            ->orWhere('email', $validatedData['email'])
            ->first();

         if (!$customer) {
            $customer = Customer::updateOrCreate([
               'email' => $validatedData['email'],
               'phone_number' => $validatedData['phoneNumber'],
               'full_name' => $validatedData['fullName'],
            ]);
         } else {
            $customer->full_name = $validatedData['fullName'];
            $customer->phone_number = $validatedData['phoneNumber'];
            $customer->email = $validatedData['email'];
         }


         $booked = Tour\TourBooked::create([
            'customer_id' => $customer->id,
            'tour_property_id' => $property->id,
            'started_date' => $validatedData['startedDate'],
            'note' => $validatedData['note'],
            'total_price' => $total['prices']
         ]);

         $ids['booked'] = $booked->id;

         $amounts = collect($this->amounts)->filter(fn($val) => $val !== '')->map(fn($val, $id) => [
            'booked_id' => $booked->id,
            'property_price_id' => $id,
            'amount' => $val
         ])->toArray();

         $booked->amounts()->createMany($amounts);

         dispatch(new SendNotifyBookedJob($booked));
         dispatch(new CustomerBookedJob($booked));

         session()->flash('success', 'Đã đăng ký thành công');

         $this->resetForm();
      } catch (QueryException|\Error $exception) {
         $this->addError('global', 'Đã xảy ra lỗi không xác định vui lòng thử lại hoặc làm mới lại trang');

         if (!$ids->hasAny(['booked'])) return;

         Tour\TourBooked::destroy($ids->get('booked'));
      }
   }

   private function resetForm()
   {
      $this->fullName = '';
      $this->phoneNumber = '';
      $this->email = '';
      $this->note = null;
      $this->startedDate = null;
      $this->amounts = [];

      $this->resetValidation();
   }

   private function handleSumPrice($collect)
   {
      if ($collect->isEmpty()) return 0;

      $ids = $collect->keys()->map(fn($val) => ['id', (int)$val]);


      $first = $ids->first();
      $ids->shift();

      $prices = Tour\TourPropertyPrice::where([$first])
         ->orWhere($ids->toArray())
         ->get(['price', 'id'])
         ->map(fn($val) => $val->price * $collect->get(strval($val->id), 0));

      return $prices->sum();
   }
}
