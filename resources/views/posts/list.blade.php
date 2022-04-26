@extends('layouts.master')

@section('title', 'Tin tức')
@section('seo.twitter:title', 'Tin tức')
@section('seo.og:title', 'Tin tức')

@section('content')
   <section class='my-5'>
      <div class='grid grid-cols-6'>
         <div class='col-span-1'></div>
         <div class='col-span-4'>
            <div class="bg-hero-news h-28 bg-cover bg-center bg-scroll flex flex-col justify-center items-center">
               <h1 class='text-white uppercase font-semibold text-3xl'>Tin tức</h1>
               <div class='mt-3 w-10 h-[3px] bg-white'></div>
            </div>

            <livewire:posts />
         </div>
         <div class='col-span-1'></div>
      </div>
   </section>
@endsection
