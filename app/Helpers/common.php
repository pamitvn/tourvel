<?php

function get_site_title($title, $suffixes = true, $separator = '-'): string
{
   return Blade::render('{{ $title }}@if($suffixes && $siteTitle) {{ $separator }} {{ $siteTitle }} @endif', [
      'title' => trim($title),
      'siteTitle' => nova_get_setting('site_title'),
      'suffixes' => $suffixes,
      'separator' => $separator
   ]);
}

function get_nova_url($path): string
{
   $domain = URL::assetFrom('https://' . config('nova.domain'), $path, false);

   return config('nova.domain')
      ? $domain
      : URL::asset(config('nova.path', '/nova') . $path);
}
