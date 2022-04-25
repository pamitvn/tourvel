@extends('layouts.master')

@section('title', get_site_title("Đăng ký {$tour->name}"))

@section('content')
   <section>
      <div class='m-6 md:container md:mx-auto md:px-10'>
         <h1 class='font-bold text-3xl text-blue-900'>
            {{ $tour->name }}
         </h1>

         <div class='mt-8 md:mt-4 md:grid md:grid-cols-12'>
            <div class='col-span-4'>
               <p><b>Liên hệ</b>: {{ !empty($property->contact_phone) ? $property->contact_phone :  '0000000' }}</p>
               <p><b>Khởi hành</b>: {{ $property->started_date->format('d/m/Y') }}</p>
               <p><b>Thời gian</b>: {{ $property->time ?? $tour->timetables_count . ' ngày' }}</p>
               <p><b>Phương tiện</b>: {{ $property->vehicle }}</p>
            </div>
            <div class='mt-6 md:mt-0 col-span-8 overflow-x-scroll md:overflow-hidden w-full'>
               <h3 class='b-title mt-0'>
                  <span class='label uppercase p-2'>Giá tour cơ bản</span>
               </h3>

               <table class="mt-1 table-auto text-center w-full">
                  <thead>
                  <tr class='bg-gray-600 text-white'>
                     @foreach($property->prices as $price)
                        <th class='px-4 py-2'>
                           {{ $price->name }}
                        </th>
                     @endforeach
                  </tr>
                  </thead>
                  <tbody>
                  <tr class='border-b last:border-none'>
                     @foreach($property->prices as $price)
                        <td class='border-gray-300 border-b-2 border-l-2 border-r-2'>
                           @if($price->price)
                              {{ number_format($price->price) }}<sup>đ</sup>
                           @else
                              Chưa có giá
                           @endif
                        </td>
                     @endforeach
                  </tr>
                  </tbody>
               </table>
               <p class="mt-2 text-sm">*giá tiền chưa bao gồm tiền típ hướng dẫn viên, chi phí visa (nếu có)</p>
            </div>
         </div>
         <livewire:tour-booking-form :tour='$tour' :property='$property' />
      </div>
   </section>
@endsection
