<?php

function get_site_title($title, $suffixes = true, $separator = '-'): string
{
   return Blade::render('{{ $title }} @if($suffixes && $siteTitle) {{ $separator }} {{ $siteTitle }} @endif', [
      'title' => $title,
      'siteTitle' => nova_get_setting('site_title'),
      'suffixes' => $suffixes,
      'separator' => $separator
   ]);
}
