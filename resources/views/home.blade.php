@php
   $categories = \App\Models\Tour\TourCategory::whereHas('tours.properties', fn($query) => $query->where('status', \App\Enums\TourStatusEnum::Seats))->get();
@endphp

@extends('layouts.master')

@section('title', nova_get_setting('site_title', nova_get_setting('site_name')))

@section('content')
   @foreach($categories as $category)
      <livewire:tour-category :category="$category" />
   @endforeach
@endsection
