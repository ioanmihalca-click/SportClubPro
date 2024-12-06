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
                    <button @click="$dispatch('open-unpaid-modal')"
                        class="inline-flex items-center mt-2 space-x-2 text-2xl font-bold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                        <span>{{ $stats['unpaid_members_count'] }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
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
                    toolbar: { show: false },
                    background: 'transparent'
                },
                series: [{
                    name: 'Încasări',
                    data: {{ json_encode($stats['charts']['payments']['data']) }}
                }],
                xaxis: {
                    categories: {{ json_encode($stats['charts']['payments']['labels']) }},
                    labels: {
                        style: {
                            colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280'
                        }
                    }
                },
                grid: {
                    borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#E5E7EB'
                },
                colors: ['#4F46E5'],
                theme: {
                    mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                }
            });
            chart.render();
            
            window.addEventListener('theme-toggle', function() {
                chart.updateOptions({
                    theme: {
                        mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                    },
                    grid: {
                        borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#E5E7EB'
                    },
                    xaxis: {
                        labels: {
                            style: {
                                colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280'
                            }
                        }
                    }
                })
            });">
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
                    toolbar: { show: false },
                    background: 'transparent'
                },
                series: [{
                    name: 'Membri Noi',
                    data: {{ json_encode($stats['charts']['members']['data']) }}
                }],
                xaxis: {
                    categories: {{ json_encode($stats['charts']['members']['labels']) }},
                    labels: {
                        style: {
                            colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280'
                        }
                    }
                },
                grid: {
                    borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#E5E7EB'
                },
                colors: ['#8B5CF6'],
                stroke: {
                    curve: 'smooth'
                },
                theme: {
                    mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                }
            });
            chart.render();
            
            window.addEventListener('theme-toggle', function() {
                chart.updateOptions({
                    theme: {
                        mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                    },
                    grid: {
                        borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#E5E7EB'
                    },
                    xaxis: {
                        labels: {
                            style: {
                                colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280'
                            }
                        }
                    }
                })
            });">
                <div x-ref="membersChart"></div>
            </div>
        </div>
    </div>


    <!-- Modal Membri cu Restanțe -->
<div x-cloak 
    x-show="show"
    x-data="{
   show: false,
   sortField: 'name',
   sortDirection: 'asc',
   members: @js($stats['unpaid_members_details']),
   sort() {
       this.members.sort((a, b) => {
           let aVal = a[this.sortField],
               bVal = b[this.sortField];
           return this.sortDirection === 'asc' ?
               (aVal > bVal ? 1 : -1) :
               (aVal < bVal ? 1 : -1);
       });
   },
   sortData(field) {
       if (this.sortField === field) {
           this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
       } else {
           this.sortField = field;
           this.sortDirection = 'asc';
       }
       this.sort();
   }
}" 
   @open-unpaid-modal.window="show = true; sort()" 
   @keydown.escape.window="show = false"
   class="relative z-50">
   
   <!-- Backdrop -->
   <div class="fixed inset-0 z-40 bg-gray-500 bg-opacity-75" @click="show = false"></div>

   <!-- Modal -->
   <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
       <div class="w-full max-w-4xl bg-white rounded-lg shadow-xl dark:bg-gray-800" @click.away="show = false">
           <!-- Header -->
           <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
               <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                   Membri cu Restanțe - {{ now()->format('F Y') }}
               </h3>
               <button @click="show = false" class="text-gray-400 hover:text-gray-500">
                   <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                   </svg>
               </button>
           </div>

           <!-- Content -->
           <div class="p-4">
               <!-- Table pentru desktop -->
               <div class="hidden md:block">
                   <div class="h-[calc(100vh-16rem)] overflow-y-auto">
                       <table class="w-full">
                           <thead class="sticky top-0 bg-white dark:bg-gray-800">
                               <tr class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase border-b dark:border-gray-700">
                                   <th class="p-4 cursor-pointer" @click="sortData('name')">
                                       <div class="flex items-center space-x-1">
                                           <span>Nume</span>
                                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                           </svg>
                                       </div>
                                   </th>
                                   <th class="p-4">Contact</th>
                                   <th class="p-4">Grupă</th>
                                   <th class="p-4">Tip Cotizație</th>
                                   <th class="p-4 cursor-pointer" @click="sortData('last_payment_date')">
                                       <div class="flex items-center space-x-1">
                                           <span>Ultima Plată</span>
                                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                           </svg>
                                       </div>
                                   </th>
                               </tr>
                           </thead>
                           <tbody>
                               <template x-for="member in members" :key="member.id">
                                   <tr class="border-b dark:border-gray-700">
                                       <td class="p-4 text-gray-900 dark:text-gray-100" x-text="member.name"></td>
                                       <td class="p-4 text-gray-600 dark:text-gray-400">
                                           <div class="text-sm" x-text="member.phone"></div>
                                           <div class="text-sm" x-text="member.email"></div>
                                       </td>
                                       <td class="p-4 text-gray-600 dark:text-gray-400" x-text="member.group"></td>
                                       <td class="p-4 text-gray-600 dark:text-gray-400" x-text="member.fee_type"></td>
                                       <td class="p-4 text-gray-600 dark:text-gray-400">
                                           <div x-text="member.last_payment_date"></div>
                                           <div class="text-sm" x-show="member.last_payment_amount > 0">
                                               <span x-text="member.last_payment_amount"></span> RON
                                           </div>
                                       </td>
                                   </tr>
                               </template>
                           </tbody>
                       </table>
                   </div>
               </div>

               <!-- Cards pentru mobile -->
               <div class="md:hidden">
                   <div class="h-[calc(100vh-12rem)] overflow-y-auto">
                       <div class="space-y-4">
                           <template x-for="member in members" :key="member.id">
                               <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                                   <div class="flex items-start justify-between mb-2">
                                       <div class="font-medium text-gray-900 dark:text-gray-100" x-text="member.name"></div>
                                       <div class="text-sm text-gray-500 dark:text-gray-400" x-text="member.group"></div>
                                   </div>

                                   <div class="space-y-2 text-sm">
                                       <!-- Contact -->
                                       <div class="flex flex-col text-gray-600 dark:text-gray-400">
                                           <div x-show="member.phone !== 'Nespecificat'">
                                               <span x-text="member.phone"></span>
                                           </div>
                                           <div x-show="member.email !== 'Nespecificat'">
                                               <span x-text="member.email"></span>
                                           </div>
                                       </div>

                                       <!-- Cotizație -->
                                       <div class="text-gray-600 dark:text-gray-400">
                                           <span class="font-medium">Tip Cotizație:</span>
                                           <span x-text="member.fee_type"></span>
                                       </div>

                                       <!-- Ultima plată -->
                                       <div class="text-gray-600 dark:text-gray-400">
                                           <span class="font-medium">Ultima plată:</span>
                                           <div class="flex items-center space-x-2">
                                               <span x-text="member.last_payment_date"></span>
                                               <span x-show="member.last_payment_amount > 0">
                                                   (<span x-text="member.last_payment_amount"></span> RON)
                                               </span>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </template>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
</div>