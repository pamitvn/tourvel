<!doctype html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>
<head>
   <meta charset='UTF-8'>
   <meta name='viewport'
         content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
   <meta http-equiv='X-UA-Compatible' content='ie=edge'>

   <title>@yield('title', '')</title>

   @if(nova_get_setting('site_favicon') && Storage::exists(nova_get_setting('site_favicon')))
      <link rel="apple-touch-icon" sizes="180x180" href="{{ Storage::url(nova_get_setting('site_favicon')) }}">
      <link rel="icon" type="{{ mime_content_type(storage_path('app/public/'.nova_get_setting('site_favicon'))) }}"
            sizes="32x32" href="{{ Storage::url(nova_get_setting('site_favicon')) }}">
      <link rel="icon" type="{{ mime_content_type(storage_path('app/public/'.nova_get_setting('site_favicon'))) }}"
            sizes="16x16" href="{{ Storage::url(nova_get_setting('site_favicon')) }}">
   @endif

   @hasSection('seo.title')
      <meta name="title" content="@yield('seo.title')">
   @else
      <meta name="title" content="{{ $__env->yieldContent('title') }}">
   @endif

   @hasSection('seo.description')
      <meta name="description" content="@yield('seo.description')">
   @elseif(nova_get_setting('seo_description'))
      <meta name="description" content="{{ nova_get_setting('seo_description') }}">
   @endif

   @hasSection('seo.keywords')
      <meta name="keywords" content="@yield('seo.keywords')">
   @elseif(nova_get_setting('seo_keyword'))
      <meta name="keywords" content="{{ nova_get_setting('seo_keyword') }}">
   @endif

   <!-- Twitter -->
   @hasSection('seo.twitter:card')
      <meta name="twitter:card" content="@yield('seo.twitter:card', 'summary_large_image')">
   @endif

   @hasSection('seo.twitter:title')
      <meta name="twitter:title" content="@yield('seo.twitter:title')">
   @elseif(nova_get_setting('seo_title'))
      <meta name="twitter:title" content="{{ nova_get_setting('seo_title') }}">
   @endif

   @hasSection('seo.twitter:description')
      <meta name="twitter:description" content="@yield('seo.twitter:description')">
   @elseif(nova_get_setting('seo_description'))
      <meta name="twitter:description" content="{{ nova_get_setting('seo_description') }}">
   @endif

   @hasSection('seo.twitter:image')
      <meta name="twitter:image" content="@yield('seo.twitter:image')">
   @elseif(nova_get_setting('seo_image') && Storage::exists(nova_get_setting('seo_image')))
      <meta name="twitter:image" content="{{ url(Storage::url(nova_get_setting('seo_image'))) }}">
   @endif

   <!-- Open Graph general (Facebook, Pinterest)-->
   @hasSection('seo.og:title')
      <meta name="og:title" content="@yield('seo.og:title')">
   @elseif(nova_get_setting('seo_title'))
      <meta name="og:title" content="{{ nova_get_setting('seo_title') }}">
   @endif

   @hasSection('seo.og:description')
      <meta name="og:description" content="@yield('seo.og:description')">
   @elseif(nova_get_setting('seo_description'))
      <meta name="og:description" content="{{ nova_get_setting('seo.og:description') }}">
   @endif

   @hasSection('seo.og:url')
      <meta name="og:url" content="@yield('seo.og:url')">
   @else
      <meta name="og:url" content="{{ request()->fullUrl() }}">
   @endif

   @hasSection('seo.og:site_name')
      <meta name="og:site_name" content="@yield('og:site_name')">
   @elseif(nova_get_setting('site_name'))
      <meta name="og:site_name" content="{{ nova_get_setting('site_name') }}">
   @endif

   @hasSection('seo.og:type')
      <meta name="og:type" content="@yield('seo.og:type','website')">
   @endif

   @hasSection('seo.og:image')
      <meta name="og:image" content="@yield('seo.og:image')">
   @elseif(nova_get_setting('seo_image') && Storage::exists(nova_get_setting('seo_image')))
      <meta name="og:image" content="{{ url(Storage::url(nova_get_setting('seo_image'))) }}">
   @endif

   @hasSection('seo.fb:app_id')
      <meta property="fb:app_id" content="@yield('seo.fb:app_id')">
   @elseif(nova_get_setting('seo_facebook_app_id'))
      <meta property="fb:app_id" content="{{ nova_get_setting('seo_facebook_app_id') }}">
   @endif

   <link rel='stylesheet' href='{{ asset('css/app.css') }}'>
   <link rel='stylesheet' href='{{ asset('fontawesome/css/all.css') }}'>
   @livewireStyles
   @stack('head')
   <div id="fb-root"></div>
   <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v13.0"
           nonce="9TbDZbSW"></script>
   @if(nova_get_setting('custom_head'))
      {!! nova_get_setting('custom_head') !!}
   @endif
</head>
<body class='bg-gray-100'>

@include('layouts.parents.header')
@yield('content')
@include('layouts.parents.footer')

<script src='{{ asset('js/app.js') }}'></script>
@livewireScripts
@stack('script')
@if(nova_get_setting('custom_script'))
   {!! nova_get_setting('custom_script') !!}
@endif
</body>
</html>
