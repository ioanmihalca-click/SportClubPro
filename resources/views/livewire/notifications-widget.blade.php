
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="relative p-1 text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 flex items-center justify-center w-4 h-4 text-xs text-white bg-red-500 rounded-full">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <div x-cloak x-show="open" 
         @click.away="open = false"
         x-transition
         class="absolute right-0 mt-2 bg-white rounded-lg shadow-lg w-80 dark:bg-gray-800 ring-1 ring-black ring-opacity-5">
        <div class="p-2">
            <h3 class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                Notificări
            </h3>
            
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($notifications as $notification)
                    <div class="p-4 {{ !$notification->is_read ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <div class="flex items-start justify-between">
                            <div>
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
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-sm text-gray-500 dark:text-gray-400">
                        Nu există notificări
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>