<div class='tourList__item'>
   <div class='md:col-span-2'>
      <a href='{{ route('tour.detail', $tour->slug) }}'>
         <img
            class='w-full h-full object-cover md:h-64'
            src='{{ Storage::url($tour->cover_image) }}'
            alt='Image'
         >
      </a>
   </div>
   <div class='mt-3 md:col-span-3 md:mt-2'>
      <div class='text-center md:text-left'>
         <span class='tourList__price'>
            {{ number_format($tour->min_price) }}<sup>đ</sup>
            @if($tour->min_price !== $tour->max_price)
               - {{ number_format($tour->max_price) }}<sup>đ</sup>
            @endif
         </span>
      </div>
      <h3 class='uppercase text-cyan-600 text-xl mt-2'>
         <a href='{{ route('tour.detail', $tour->slug) }}'>{{ $tour->name }}</a>
      </h3>

      @isset($tour->location)
         <p class='mt-3 text-base'>
            <b>
               {{ $tour->location['from'] }} - {{ $tour->location['to'] }}
            </b>
         </p>
      @endif
      <div class='mt-3 truncate text-sm max-h-16 overflow-y-auto'>
         {!! Str::limit($tour->short_description) !!}
      </div>
   </div>
   <div class='my-3 text-center md:col-span-1 md:flex md:relative md:mt-0'>
      <a
         href='{{ route('tour.detail', $tour->slug) }}'
         class='md:absolute top-8 right-0 bg-yellow-600 text-white py-2 px-8 rounded-sm transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-yellow-800 duration-300'>
         Chi tiết
      </a>
   </div>
</div>
