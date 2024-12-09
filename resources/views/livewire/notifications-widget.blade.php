<div class="relative" x-data="{ open: false }">
    <!-- Notification Button -->
    <button @click="open = !open" 
            class="relative inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out rounded-md dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        @if($unreadCount > 0)
            <span class="absolute -top-1.5 -right-1.5 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Notifications Dropdown/Modal -->
    <div x-cloak x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="fixed inset-x-0 z-50 mx-2 top-16 md:top-12 sm:absolute sm:inset-x-auto sm:right-0 sm:w-80 sm:mx-0 sm:mt-2 sm:origin-top-right">
        
        <div class="overflow-hidden bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800">
            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                    Notificări
                </h3>
                <!-- Close button for mobile -->
                <button @click="open = false" class="p-1 text-gray-500 sm:hidden hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Notifications List -->
            <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-[80vh] sm:max-h-[600px] overflow-y-auto">
                @forelse($notifications as $notification)
                    <div class="relative {{ !$notification->is_read ? 'bg-blue-50/50 dark:bg-blue-900/20' : '' }}">
                        <div class="p-4 sm:px-4 sm:py-3">
                            <div class="flex items-start justify-between gap-x-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-base font-medium text-gray-900 sm:text-sm dark:text-gray-100">
                                        {{ $notification->title }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500 break-words dark:text-gray-400">
                                        {{ $notification->message }}
                                    </p>
                                    <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                @if(!$notification->is_read)
                                    <button wire:click="markAsRead({{ $notification->id }})" 
                                            class="flex-shrink-0 p-2 -m-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 sm:p-0 sm:m-0">
                                        <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-8 text-sm text-center text-gray-500 dark:text-gray-400">
                        Nu există notificări
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>