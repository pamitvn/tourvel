@if($hasTour)
   <section class='mt-6 mx-6 md:container md:mx-auto tourList'>
      <h3 class='tourList-title'>
         <a class='tourList-title__label'>
            {{ $name }}
         </a>
      </h3>

      @foreach($tours as $tour)
         <x-category.tour-category-item :tour="$tour" />
      @endforeach

      @if($hasMorePages)
         <div class='flex justify-center items-center mt-6'>
            <button
               class='bg-red-500 text-white px-6 py-2 rounded-md transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-red-700 duration-300'
               wire:click="loadMore">
               Xem thêm
            </button>
         </div>
      @endif
   </section>
@endif
