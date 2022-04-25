@component('mail::message')
   # Thông tin liên hệ mới

   Đã liên hệ vào lúc {{ $data->get('at', now()) }}

   - Họ và tên: {{ $data->get('fullName') }}
   - E-Mail: {{ $data->get('email') }}
   - Số điện thoại: {{ $data->get('phoneNumber') }}
   - Address: {{ $data->get('address') }}
   - Thông điệp: {{ $data->get('content') }}

   Thanks,<br>
   {{ config('app.name') }}
@endcomponent
