<div class="relative" x-data="{ open: false }">
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

    <div x-cloak x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 z-50 mt-2 origin-top-right w-80">
        
        <div class="overflow-hidden bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800">
            <!-- Header -->
            <div class="px-4 py-3 border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                    Notificări
                </h3>
            </div>

            <!-- Notifications List -->
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($notifications as $notification)
                    <div class="relative {{ !$notification->is_read ? 'bg-blue-50/50 dark:bg-blue-900/20' : '' }}">
                        <div class="px-4 py-3">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $notification->title }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $notification->message }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                @if(!$notification->is_read)
                                    <button wire:click="markAsRead({{ $notification->id }})" 
                                            class="ml-4 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-6 text-sm text-center text-gray-500 dark:text-gray-400">
                        Nu există notificări
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>