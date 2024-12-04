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
                    class="text-blue-600 border-gray-300 rounded shadow-sm dark:border-gray-600">
                <span class="ml-2 text-gray-700 dark:text-gray-300">Arată evenimente trecute</span>
            </label>

            <a href="{{ route('events.create') }}"
                class="px-4 py-2 font-bold text-white bg-teal-500 rounded hover:bg-teal-700">
                Adaugă Eveniment
            </a>
        </div>
    </div>

    <!-- Events Cards Grid -->
    <div class="space-y-4">
        @forelse($events as $event)
            <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ $loop->iteration }}. {{ $event->name }}
                        </h3>
                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Data: {{ $event->date->format('d.m.Y') }}
                        </div>
                    </div>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $event->date->isFuture() ? 'bg-teal-100 text-teal-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $event->date->isFuture() ? 'Viitor' : 'Trecut' }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tip Eveniment</span>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $event->type }}
                        </p>
                    </div>
                    @if($event->details)
                    <div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Detalii</span>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $event->details }}
                        </p>
                    </div>
                    @endif
                </div>

                <div class="flex justify-end mt-4 space-x-3">
                    <a href="{{ route('events.participants', $event) }}"
                        class="text-teal-600 hover:text-teal-900 dark:text-teal-400 dark:hover:text-teal-300">
                        Participanți
                    </a>
                    <a href="{{ route('events.edit', $event) }}"
                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
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

        <div class="mt-4">
            {{ $events->links() }}
        </div>
    </div>
</div>