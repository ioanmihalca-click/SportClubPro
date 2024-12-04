<div class="space-y-6">
    <form wire:submit="submitForm" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nume</label>
            <input type="text" wire:model="name"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:focus:ring-teal-500 dark:focus:border-teal-500">
            @error('name')
                <span class="text-xs text-red-500 dark:text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
            <input type="email" wire:model="email"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:focus:ring-teal-500 dark:focus:border-teal-500">
            @error('email')
                <span class="text-xs text-red-500 dark:text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Subiect</label>
            <input type="text" wire:model="subject"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:focus:ring-teal-500 dark:focus:border-teal-500">
            @error('subject')
                <span class="text-xs text-red-500 dark:text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Mesaj</label>
            <textarea wire:model="message" rows="6"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:focus:ring-teal-500 dark:focus:border-teal-500"></textarea>
            @error('message')
                <span class="text-xs text-red-500 dark:text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit"
                class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-md shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 dark:hover:bg-teal-500 dark:focus:ring-offset-gray-800">
                <span wire:loading.remove wire:target="submitForm">
                    Trimite Mesaj
                </span>
                <span wire:loading wire:target="submitForm">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </span>
            </button>

            @if (session()->has('message'))
                <div class="relative px-4 py-3 mt-4 text-teal-700 bg-teal-100 border border-teal-400 rounded dark:bg-teal-900/50 dark:border-teal-500 dark:text-teal-200">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </form>
</div>