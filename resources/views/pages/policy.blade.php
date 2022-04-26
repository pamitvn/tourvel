@extends('layouts.master')

@section('title', get_site_title('Chích sách'))
@section('seo.og:title', get_site_title('Chích sách'))
@section('seo.twitter:title', get_site_title('Chích sách'))

@section('content')
   <section class='my-5'>
      <div class='grid grid-cols-6'>
         <div class='col-span-1'></div>
         <div class='col-span-4'>
            <h1 class='mt-0 text-4xl font-bold text-center'>
               Chính sách
            </h1>
            <article class='mt-3'>
               {!! nova_get_setting('page_policy_content') !!}
            </article>
         </div>
         <div class='col-span-1'></div>
      </div>
   </section>
@endsection
