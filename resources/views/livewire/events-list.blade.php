<div class="space-y-6">
    <!-- Header with Search and Filters -->
    <div class="flex flex-col justify-between space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
        <div class="flex-1">
            <input type="text" wire:model.live="search" placeholder="Caută evenimente..."
                class="w-full border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
        </div>

        <div class="flex items-center space-x-4">
            <label class="flex items-center">
                <input type="checkbox" wire:model.live="showPast"
                    class="text-indigo-600 border-gray-300 rounded shadow-sm dark:border-gray-600">
                <span class="ml-2 text-gray-700 dark:text-gray-300">Arată evenimente trecute</span>
            </label>

            <a href="{{ route('events.create') }}"
                class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                Adaugă Eveniment
            </a>
        </div>
    </div>

    <!-- Events List -->
    <div class="bg-white divide-y divide-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:divide-gray-700">
        @forelse($events as $event)
            <div class="flex items-center justify-between p-6">
                <div class="flex-1">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ $event->name }}
                    </h3>
                    <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        <p>Data: {{ $event->date->format('d.m.Y') }}</p>
                        <p>Tip: {{ $event->type }}</p>
                        @if ($event->details)
                            <p class="mt-2">{{ $event->details }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('events.participants', $event) }}"
                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                        Participanți
                    </a>
                    <a href="{{ route('events.edit', $event) }}"
                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                        Editează
                    </a>
                    <button wire:click="$dispatch('confirmDelete', { id: {{ $event->id }} })"
                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                        Șterge
                    </button>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                Nu există evenimente {{ $showPast ? '' : 'viitoare' }}.
            </div>
        @endforelse

        <div class="p-4">
            {{ $events->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ showDeleteModal: false, eventToDelete: null }" @confirm-delete.window="showDeleteModal = true; eventToDelete = $event.detail.id">
        <!-- Modal implementation similar to members delete modal -->
    </div>
</div>
