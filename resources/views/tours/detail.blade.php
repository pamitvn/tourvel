@extends('layouts.master')

@php
   $properties = $tour->properties()->whereStatus(\App\Enums\TourStatusEnum::Seats)->get();
@endphp

@section('title', get_site_title($tour->name))
@section('seo.og:title', get_site_title($tour->name))
@section('seo.twitter:title', get_site_title($tour->name))
@section('seo.description', $tour->short_description)
@section('seo.og:description', $tour->short_description)
@section('seo.og:image', url(Storage::url($tour->cover_image)))
@section('seo.twitter:image', url(Storage::url($tour->cover_image)))

@section('content')
   <section class='my-5'>
      <div class='grid grid-cols-6'>
         <div class='col-span-1'></div>
         <div class='col-span-4'>
            <div class=''>
               <h1 class='font-bold font-semibold text-3xl text-center'>{{ $tour->name }}</h1>

               <div class='mt-3 p-4 bg-white rounded-md'>
                  {!! $tour->description !!}
               </div>
            </div>

            @if($tour->timetables->isNotEmpty())
               <h3 class='b-title my-4 mt-8'>
                  <span class='label'>Thời gian biểu</span>
               </h3>
               <div class='bg-white p-4 rounded-b-md'>
                  @foreach($tour->timetables as $key => $timetable)
                     <div class='mt-2 first:mt-0 p-2'>
                        <h3>
                           <span class='bg-red-500 px-2 py-1 text-center'>
                              <i class="fa-duotone fa-calendar w-3 h-3 text-white"></i>
                           </span>
                           <span class='bg-blue-500 text-white px-2 py-1 rounded-tr-md rounded-br-md'>
                            {{ $timetable->day ?? 'Day ' . ++$key }}
                            </span>
                           <span class='ml-2 font-sans text-base font-bold'>
                              {{ $timetable->name }}
                           </span>
                        </h3>

                        <div class='mt-2'>
                           {!! $timetable->description !!}
                        </div>
                     </div>
                  @endforeach
               </div>
            @endif

            @if($tour->policy)
               <h3 class='b-title my-4 mt-8'>
                  <span class='label'>Chính sách</span>
               </h3>
               <div class='bg-white p-4 rounded-b-md'>
                  {!! $tour->policy !!}
               </div>
            @endif

            @if($properties->isNotEmpty())
               <h3 class='b-title my-4 mt-8'>
                  <span class='label'>Bảng giá </span>
               </h3>
               <div class='bg-white p-4 rounded-b-md overflow-x-scroll w-full'>
                  <table class="table-auto text-left w-full">
                     <thead>
                     <tr class='bg-green-700 text-white'>
                        <th class='px-4 py-2'>Ngày</th>
                        <th class='px-4 py-2'>Phương tiện</th>
                        <th class='px-4 py-2'>Giá</th>
                        <th class='px-4 py-2'>Tình trạng</th>
                        <th class='px-4 py-2'></th>
                     </tr>
                     </thead>
                     <tbody>
                     @foreach($properties as $property)
                        <tr class='border-b last:border-none'>
                           <td class='px-4 py-2'>{{ $property->started_date->format('d/m/Y') }}</td>
                           <td class='px-4 py-2'>{{ $property->vehicle }}</td>
                           <td class='px-4 py-2 text-red-600'>
                              @if($property->prices->min('price'))
                                 {{ number_format($property->prices->min('price')) }}<sup>đ</sup>
                              @else
                                 Chưa cập nhật giá
                              @endif
                           </td>
                           <td class='px-4 py-2'>
                              @if($property->amount === -1)
                                 {{ \App\Enums\TourStatusEnum::label($property->status->value) }}
                              @else
                                 {{ $property->seat_available }}/{{ $property->amount }}
                              @endif
                           </td>
                           <td class='px-4 md:py-4'>
                              @if($property->amount === -1 || $property->seat_available < $property->amount)
                                 <a
                                    href='{{ route('tour.booking', ['slug' => $tour->slug, 'property' => $property->id]) }}'
                                    class='block bg-gradient-to-l hover:bg-gradient-to-r from-purple-500 to-pink-500 hover:from-pink-500 hover:to-purple-500 px-3 py-2 text-white rounded-md text-center'
                                 >
                                    Đặt chỗ
                                 </a>
                              @endif
                           </td>
                        </tr>
                     @endforeach
                     </tbody>
                  </table>
               </div>
            @endif

            <h3 class='b-title my-4 mt-8'>
               <span class='label'>Bình luận</span>
            </h3>

            <div class='bg-white p-4 rounded-b-md w-full'>
               <div class="fb-comments" data-href="{{ request()->fullUrl() }}"
                    data-width="100%" data-numposts="5"></div>
            </div>

         </div>
         <div class='col-span-1'></div>
      </div>
   </section>
@endsection
