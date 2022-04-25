<!doctype html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>
<head>
   <meta charset='UTF-8'>
   <meta name='viewport'
         content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
   <meta http-equiv='X-UA-Compatible' content='ie=edge'>

   <title>@yield('title', '')</title>

   <link rel='stylesheet' href='{{ asset('css/app.css') }}'>
   <link rel='stylesheet' href='{{ asset('fontawesome/css/all.css') }}'>
   @livewireStyles
   @stack('head')
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
