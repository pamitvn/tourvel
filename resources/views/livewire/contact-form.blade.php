<form wire:submit.prevent="handleFormSubmit">
   @if(session()->has('success'))
      <div class='bg-green-500 p-2 mb-4 rounded-md text-white'>
         {{ session('success') }}
      </div>
   @endif
   <div class='grid grid-cols-1 gap-3'>
      <label class='block'>
         <input type='text'
                class='form-input mt-1 block w-full rounded-md bg-gray-100  border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('fullName') border-red-500 @enderror'
                placeholder='Họ & Tên'
                wire:model.debounce.300ms='fullName'
         >
         @error('fullName')
         <span class='ml-2 text-sm text-red-600'>{{ $message }}</span>
         @enderror
      </label>
      <label class='block'>
         <input type='email'
                class='form-input mt-1 block w-full rounded-md bg-gray-100  border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('email') border-red-500 @enderror'
                placeholder='E-Mail'
                wire:model.debounce.300ms='email'
         >
         @error('email')
         <span class='ml-2 text-sm text-red-600'>{{ $message }}</span>
         @enderror
      </label>
      <label class='block'>
         <input type='tel'
                class='form-input mt-1 block w-full rounded-md bg-gray-100  border-transparent focus:border-gray-500 focus:bg-white focus:ring-0'
                placeholder='Số điện thoại'
                wire:model.debounce.300ms='phoneNumber'
         >
      </label>

      <label class='block'>
         <input type='text'
                class='form-input mt-1 block w-full rounded-md bg-gray-100  border-transparent focus:border-gray-500 focus:bg-white focus:ring-0'
                placeholder='Địa chỉ'
                wire:model.debounce.300ms='address'
         >
      </label>

      <label class='block'>
         <textarea
            class='form-input mt-1 block w-full rounded-md bg-gray-100  border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('content') border-red-500 @enderror'
            rows='4'
            placeholder='Thông điệp'
            wire:model.debounce.300ms='content'
         ></textarea>

         @error('content')
         <span class='ml-2 text-sm text-red-600'>{{ $message }}</span>
         @enderror
      </label>

      <div class='flex justify-center items-center'>
         <button type='submit' class='bg-green-600 px-6 py-2 rounded-sm text-white text-center'>Gửi</button>
      </div>
   </div>
</form>
