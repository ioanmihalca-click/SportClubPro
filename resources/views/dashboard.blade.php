<x-app-layout>
    <x-slot name="header">
       <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Flex container pentru conținut și sidebar -->
            <div class="flex gap-6">
                <!-- Main content -->
                <div class="flex-1">
                    @if (!auth()->user()->club_id)
                        <livewire:create-club />
                    @else
                        <livewire:dashboard />
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
