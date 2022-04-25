@extends('layouts.master')

@section('title', get_site_title('Liên hệ - góp ý'))

@section('content')
   <section class='mx-6 mt-6 md:container md:mx-auto'>
      <div class="bg-hero-contact h-28 bg-cover bg-center bg-scroll flex flex-col justify-center items-center">
         <h1 class='text-white uppercase font-semibold text-3xl'>Liên hệ với chúng tôi</h1>
         <div class='mt-3 w-28 h-[3px] bg-white'></div>
      </div>

      <div class='mt-6 grid grid-cols-1 md:grid-cols-12 gap-6'>
         <div class='md:col-span-5'>
            @if(nova_get_setting('contact_company_name'))
               <h3 class='uppercase'>{{ nova_get_setting('contact_company_name') }}</h3>
            @endif

            @if(nova_get_setting('contact_address'))
               <div class='mt-3 grid grid-cols-1 gap-6'>
                  <div class='flex space-x-5'>
                     <span class='basis-1/4 bg-orange-500 p-6 flex justify-center items-center'>
                        <i class="fa-light fa-location-dot text-3xl text-white"></i>
                     </span>
                     <div class='basis-2/3 flex flex-col '>
                        <span class='uppercase'>Địa chỉ</span>
                        <span class='text-sm'>{{ nova_get_setting('contact_address') }}</span>
                     </div>
                  </div>
               </div>
            @endif
            @if(nova_get_setting('contact_phone'))
               <div class='mt-3 grid grid-cols-1 gap-6'>
                  <div class='flex space-x-5'>
                     <span class='basis-1/4 bg-orange-500 p-6 flex justify-center items-center'>
                        <i class="fa-light fa-phone text-3xl text-white"></i>
                     </span>
                     <div class='basis-2/3 flex flex-col '>
                        <span class='uppercase'>Liên hệ góp ý</span>
                        <a href='tel:+84{{ nova_get_setting('contact_phone') }}'>
                           <span class='text-sm'>Điện thoại: {{ nova_get_setting('contact_phone') }}</span>
                        </a>
                     </div>
                  </div>
               </div>
            @endif
            @if(nova_get_setting('contact_email'))
               <div class='mt-3 grid grid-cols-1 gap-6'>
                  <div class='flex space-x-5'>
                     <span class='basis-1/4 bg-orange-500 p-6 flex justify-center items-center'>
                        <i class="fa-light fa-envelope text-3xl text-white"></i>
                     </span>
                     <div class='basis-2/3 flex flex-col '>
                        <span class='uppercase'>Email</span>
                        <a href='mailto:{{ nova_get_setting('contact_email') }}'>
                           <span class='text-sm'>{{ nova_get_setting('contact_email') }}</span>
                        </a>
                     </div>
                  </div>
               </div>
            @endif
         </div>
         <div class='md:col-span-7'>
            <div class='bg-white w-full p-4 rounded-md shadow-md'>
               <livewire:contact-form />
            </div>
         </div>
      </div>

   </section>
@endsection
