<div class="splide__track">
   <ul class="splide__list">
      @foreach($sliders as $slider)
         <li class="splide__slide aspect-w-16 aspect-h-9 md:aspect-h-6 md:aspect-w-13 lg:aspect-h-3 lg:aspect-w-10">
            <img
               width='100%'
               height='100%'
               class='"w-full h-full object-center object-cover lg:w-full lg:h-full'
               src='{{ Storage::url($slider->cover_image) }}'
               alt='Slider {{ $slider->id }}'>
         </li>
      @endforeach
   </ul>
</div>
