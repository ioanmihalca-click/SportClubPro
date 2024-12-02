<div>
    <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-3">
        <!-- Membri Activi -->
        <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
            <div class="flex items-center">
                <div class="p-3 bg-blue-500 bg-opacity-75 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $stats['total_members'] }}
                    </h4>
                    <div class="text-gray-500 dark:text-gray-400">Membri Activi</div>
                </div>
            </div>
        </div>

        <!-- Plăți Luna Curentă -->
        <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
            <div class="flex items-center">
                <div class="p-3 bg-green-500 bg-opacity-75 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        {{ number_format($stats['monthly_payments'], 2) }} RON</h4>
                    <div class="text-gray-500 dark:text-gray-400">Încasări Luna {{ now()->format('F') }}</div>
                </div>
            </div>
        </div>

        <!-- Prezențe Astăzi -->
        <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
            <div class="flex items-center">
                <div class="p-3 bg-purple-500 bg-opacity-75 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        {{ $stats['today_attendances'] }}</h4>
                    <div class="text-gray-500 dark:text-gray-400">Prezențe Astăzi</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 mb-8 lg:grid-cols-2">
        <!-- Membri cu Restanțe -->
        <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
            <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-200">Situație Plăți</h2>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Membri cu cotizația neplătită luna aceasta:</p>
                    <p class="mt-2 text-2xl font-bold text-red-600 dark:text-red-400">{{ $stats['unpaid_members'] }}</p>
                </div>
            </div>
        </div>

        <!-- Evenimente Următoare -->
        <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
            <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-200">Evenimente Următoare</h2>
            @if ($stats['upcoming_events']->count() > 0)
                <div class="space-y-4">
                    @foreach ($stats['upcoming_events'] as $event)
                        <div class="flex items-center justify-between pb-2 border-b dark:border-gray-700">
                            <div>
                                <h4 class="font-medium text-gray-700 dark:text-gray-200">{{ $event->name }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $event->date->format('d.m.Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">Nu există evenimente programate</p>
            @endif
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 mb-8 lg:grid-cols-2">
        <!-- Grafic Încasări Lunare -->
        <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
            <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-200">Evoluție Încasări</h2>
            <div x-data="{ chart: null }" x-init="chart = new ApexCharts($refs.paymentsChart, {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: false }
                },
                series: [{
                    name: 'Încasări',
                    data: {{ json_encode($stats['charts']['payments']['data']) }}
                }],
                xaxis: {
                    categories: {{ json_encode($stats['charts']['payments']['labels']) }},
                    labels: {
                        style: { colors: '#6B7280' }
                    }
                },
                colors: ['#4F46E5'],
                theme: {
                    mode: 'light'
                }
            });
            chart.render();">
                <div x-ref="paymentsChart"></div>
            </div>
        </div>

        <!-- Grafic Membri -->
        <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
            <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-200">Evoluție Membri</h2>
            <div x-data="{ chart: null }" x-init="chart = new ApexCharts($refs.membersChart, {
                chart: {
                    type: 'line',
                    height: 350,
                    toolbar: { show: false }
                },
                series: [{
                    name: 'Membri Noi',
                    data: {{ json_encode($stats['charts']['members']['data']) }}
                }],
                xaxis: {
                    categories: {{ json_encode($stats['charts']['members']['labels']) }},
                    labels: {
                        style: { colors: '#6B7280' }
                    }
                },
                colors: ['#8B5CF6'],
                stroke: {
                    curve: 'smooth'
                },
                theme: {
                    mode: 'light'
                }
            });
            chart.render();">
                <div x-ref="membersChart"></div>
            </div>
        </div>
    </div>
</div>
