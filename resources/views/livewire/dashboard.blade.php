// resources/views/livewire/dashboard.blade.php
<div>
    <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-3">
        <!-- Membri Activi -->
        <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <div class="flex items-center">
                <div class="p-3 bg-blue-500 bg-opacity-75 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700">{{ $stats['total_members'] }}</h4>
                    <div class="text-gray-500">Membri Activi</div>
                </div>
            </div>
        </div>

        <!-- Plăți Astăzi -->
        <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <div class="flex items-center">
                <div class="p-3 bg-green-500 bg-opacity-75 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700">{{ $stats['today_payments'] }}</h4>
                    <div class="text-gray-500">Plăți Astăzi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Evenimente Următoare -->
    <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
        <h2 class="mb-4 text-lg font-semibold text-gray-700">Evenimente Următoare</h2>
        @if($stats['upcoming_events']->count() > 0)
            <div class="space-y-4">
                @foreach($stats['upcoming_events'] as $event)
                    <div class="flex items-center justify-between pb-2 border-b">
                        <div>
                            <h4 class="font-medium text-gray-700">{{ $event->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $event->date->format('d.m.Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Nu există evenimente programate</p>
        @endif
    </div>
</div>