<div class="space-y-6">
   

    <form wire:submit="submitForm" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nume</label>
            <input type="text" wire:model="name" 
                   class="block w-full mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
            @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" wire:model="email"
                   class="block w-full mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
            @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subiect</label>
            <input type="text" wire:model="subject"
                   class="block w-full mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
            @error('subject') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mesaj</label>
            <textarea wire:model="message" rows="6"
                      class="block w-full mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"></textarea>
            @error('message') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" 
                    class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-md shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                Trimite Mesaj
            </button>

             @if (session()->has('message'))
        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded">
            {{ session('message') }}
        </div>
        
    @endif
        </div>
    </form>
</div>