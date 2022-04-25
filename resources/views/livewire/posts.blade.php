<div>
   <div class='mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12'>
      @foreach($posts as $post)
         <div class="bg-white w-full rounded overflow-hidden shadow-lg cursor-pointer">
            <a href='{{ route('posts.detail', $post->slug) }}'>
               <img class="w-full" src="{{ Storage::url($post->feature_image) }}"
                    alt="Mountain">
               <div class="px-6 py-4">
                  <div class="font-bold text-xl mb-2">
                     {{ $post->title }}
                  </div>
                  <p class="text-gray-700 text-base">
                     {{ $post->short_description }}
                  </p>
               </div>
            </a>
         </div>
      @endforeach
   </div>

   @if($hasMorePages)
      <div class='flex justify-center items-center my-6'>
         <button class='px-6 py-2 bg-red-500 text-white rounded-md shadow-md' wire:click="loadMore">
            Hiển thị thêm bài viết
         </button>
      </div>
   @endif
</div>
