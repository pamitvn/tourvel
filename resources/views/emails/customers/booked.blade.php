@component('mail::message')
   # Bạn đã đăng ký đặt chỗ thành công

   Bộ phần liên quan sẽ liên hệ bạn để xác nhận trong thời gian sớm nhất!

   ### Thông tin chi tiết:

   - **Tour**: {{ $booked->property->tour->name }}
   - **Ngày khởi hành**: {{ $booked->property->started_date->format('d/m/Y') }}
   - **Ngày khởi hành khác**: {{ $booked->started_date ? $booked->started_date->format('d/m/Y') : '---' }}
   - **Thời gian**: {{ $booked->property->time ?? $booked->property->tour->timetables_count }}
   - **Phương tiện**: {{ $booked->property->vehicle }}
   - **Yêu cầu thêm**: {{ $booked->note ?? '---' }}

   ### Các chỗ bạn đã đặt:

   @component('mail::table')
      | Loại | Số lượng | Giá |
      | :--: |:--: | :--: |
      @foreach($booked->amounts()->get() as $amount)
         | {{ $amount->propertyPrice->name }} | {{ $amount->amount }} | {{ number_format($amount->propertyPrice->price) }} |
      @endforeach
   @endcomponent

   Thanks,<br>
   {{ config('app.name') }}
@endcomponent
