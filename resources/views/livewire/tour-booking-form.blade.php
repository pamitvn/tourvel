<form wire:submit.prevent="handleSubmitForm">
   <div class='md:mt-4 md:grid md:grid-cols-12'>
      <div class='mt-8 col-span-8 pr-12'>
         <h3 class='b-title mt-0'>
            <span class='label uppercase p-2'>Thông tin liên hệ</span>
         </h3>

         @if(session()->has('success'))
            <div class='bg-green-400 text-white my-4 p-4 rounded-md shadow-md'>
               <span>{{ session('success') }}</span>
            </div>
         @endif

         @if(session()->has('error'))
            <div class='bg-red-500 text-white my-4 p-4 rounded-md shadow-md'>
               <span class='text-xl'>{{ session('error') }}</span>
            </div>
         @endif

         <div class='bg-white p-4 rounded-b-md shadow-md'>
            <div class='grid grid-cols-2 gap-6'>
               <label class='block'>
                  <span class="text-gray-700">Họ và tên <span class='text-red-700'>*</span></span>
                  <input type="text"
                         class="form-input mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('fullName') border-red-500 @enderror"
                         placeholder=""
                         wire:model.debounce.500ms='fullName'
                  >
                  @error('fullName')
                  <span class='ml-2 text-sm text-red-600'>{{ $message }}</span>
                  @enderror
               </label>
               <label class='block'>
                  <span class="text-gray-700">Số điện thoại <span class='text-red-700'>*</span></span>
                  <input type="tel"
                         class="form-input mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('phoneNumber') border-red-500 @enderror"
                         placeholder=""
                         wire:model.debounce.500ms='phoneNumber'
                  >
                  @error('phoneNumber')
                  <span class='ml-2 text-sm text-red-600'>{{ $message }}</span>
                  @enderror
               </label>
               <label class='block'>
                  <span class="text-gray-700">Email <span class='text-red-700'>*</span></span>
                  <input type="email"
                         class="form-input mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('email') border-red-500 @enderror"
                         placeholder=""
                         wire:model.debounce.500ms='email'
                  >
                  @error('email')
                  <span class='ml-2 text-sm text-red-600'>{{ $message }}</span>
                  @enderror
               </label>
               <label class='block'>
                  <span class="text-gray-700">Yêu cầu</span>
                  <textarea
                     rows='3'
                     class="form-textarea mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                     wire:model.debounce.500ms='note'
                  ></textarea>
               </label>

               <div class='col-span-2'>
                  <div class='grid grid-cols-2 gap-6'>
                     <label class='block flex items-center'>
                        <span class="text-gray-700">Ngày khởi hành khác (Nếu có)</span>
                     </label>

                     <input type="date"
                            class="form-input mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                            placeholder=""
                            wire:model.debounce.500ms='startedDate'
                     >
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class='mt-8 col-span-4'>
         <h3 class='b-title mt-0'>
            <span class='label uppercase p-2'>Số lượng khách</span>
         </h3>

         <div class='bg-white p-4 rounded-b-md shadow-md'>
            <div class='grid grid-cols-1 gap-4'>

               @foreach($property->prices as $price)
                  <label class='flex justify-between items-center'>
                     <span>{{ $price->name }}</span>
                     <input
                        class='form-input max-w-[4rem] max-h-[2rem] w-auto @error('amounts.'.$price->id) border-red-500 @enderror'
                        type='number'
                        wire:model.debounce.500ms='amounts.{{ $price->id }}'>
                     @error('amounts.'.$price->id)
                     <span class='ml-2 text-sm text-red-600'>{{ $message }}</span>
                     @enderror
                  </label>
               @endforeach

               <div class='bg-gray-900 bg-opacity-70 w-full h-[1px] my-4'></div>

               <div class='flex justify-between items-center text-sm'>
                  <span>Tổng số khách: </span>
                  <span>{{ number_format($this->total['customers']) }}</span>
               </div>

               <div class='flex justify-between items-center text-sm'>
                  <span>Tổng số tiền: </span>
                  <span>{{ number_format($this->total['prices']) }}<sup>đ</sup></span>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class='mt-6 flex justify-center'>
      <button type='submit' class='bg-green-400 text-white px-6 py-2 text-center rounded-sm shadow-md'>
         Đăng ký
      </button>
   </div>
</form>
