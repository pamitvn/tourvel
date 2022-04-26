@extends('layouts.master')

@section('title', get_site_title($post->title))
@section('seo.og:title', get_site_title($post->seo_title ?? $post->title))
@section('seo.twitter:title', get_site_title($post->seo_title ?? $post->title))
@section('seo.description', $post->seo_description ?? $post->short_description)
@section('seo.og:description', $post->seo_description ?? $post->short_description)
@section('seo.og:image', url(Storage::url($post->seo_image ??$post->feature_image)))
@section('seo.twitter:image', url(Storage::url($post->seo_image ??$post->feature_image)))

@section('content')
   <section class='my-5'>
      <div class='grid grid-cols-6'>
         <div class='col-span-1'></div>
         <div class='col-span-4'>
            <h1 class='text-3xl font-bold capitalize text-center'> {{ $post->title }}</h1>
            <div class='mt-4 bg-white w-full rounded overflow-hidden shadow-xl'>
               <div class='aspect-w-16 aspect-h-9 lg:aspect-none'>
                  <img class="w-full" src="{{ Storage::url($post->feature_image) }}"
                       alt="Mountain">
               </div>
               <p class='px-6 text-sm bg-gray-300 py-1 text-center text-black'>Xuất bản vào
                  ngày: {{ $post->created_at->format('d/m/Y') }}</p>
               <div class="px-6 py-4">
                  <div>
                     {!! $post->content !!}
                  </div>
               </div>
            </div>
         </div>
         <div class='col-span-1'></div>
      </div>
   </section>
@endsection
