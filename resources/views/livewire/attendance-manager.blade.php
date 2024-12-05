<div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
    <div wire:key="attendance-manager-{{ $activeTab }}">
        @if(session()->has('message'))
            <div class="relative px-4 py-3 mb-4 text-teal-700 bg-teal-100 border border-teal-400 rounded">
                {{ session('message') }}
            </div>
        @endif

        <!-- Tabs -->
        <div class="flex mb-6 space-x-4 border-b border-gray-200 dark:border-gray-700">
            <button wire:key="mark-tab-button" 
                    wire:click="setActiveTab('mark')"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 -mb-px text-sm font-medium {{ $activeTab === 'mark' ? 'text-teal-600 border-b-2 border-teal-500' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                <span wire:loading.class="opacity-50">Marcare Prezențe</span>
            </button>
            <button wire:key="view-tab-button"
                    wire:click="setActiveTab('view')"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 -mb-px text-sm font-medium {{ $activeTab === 'view' ? 'text-teal-600 border-b-2 border-teal-500' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                <span wire:loading.class="opacity-50">Vizualizare Prezențe</span>
            </button>
        </div>

        <!-- Loading State -->
        <div wire:loading.delay class="w-full p-4 text-center">
            <div class="inline-block w-8 h-8 border-4 rounded-full border-t-teal-500 animate-spin"></div>
        </div>

        <!-- Content -->
        <div wire:loading.delay.remove>
            @if($activeTab === 'mark')
                <div wire:key="mark-tab-content">
                    <!-- Marcare Prezențe -->
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Prezențe</h2>
                        
                        <form action="{{ route('reports.attendance') }}" method="GET" class="flex space-x-4">
                            <input type="hidden" name="start_date" value="{{ $selectedDate }}">
                            <input type="hidden" name="end_date" value="{{ $selectedDate }}">
                            <input type="hidden" name="group_id" value="{{ $selectedGroup }}">
                            
                            <button type="submit"
                                    class="px-4 py-2 font-bold text-white bg-teal-500 rounded hover:bg-teal-700">
                                Export Prezențe PDF
                            </button>
                        </form>
                    </div>

                    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2">
                        <!-- Selector Dată -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data</label>
                            <input type="date" 
                                   wire:model.live="selectedDate"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        </div>

                        <!-- Selector Grupă -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Grupa</label>
                            <select wire:model.live="selectedGroup"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                <option value="">Selectează grupa</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if($selectedGroup && $members->count() > 0)
                        <form wire:submit="saveAttendance">
                            <div class="space-y-4">
                                @foreach($members as $member)
                                    <div class="flex items-center" wire:key="member-{{ $member->id }}">
                                        <input type="checkbox"
                                               wire:model="attendees.{{ $member->id }}"
                                               class="text-teal-600 border-gray-300 rounded shadow-sm dark:border-gray-600 dark:bg-gray-700 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                                        <label class="ml-2 text-gray-700 dark:text-gray-300">{{ $member->name }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6">
                                <button type="submit"
                                        class="px-4 py-2 font-bold text-white bg-teal-500 rounded hover:bg-teal-700">
                                    Salvează Prezențe
                                </button>
                            </div>
                        </form>
                    @elseif($selectedGroup)
                        <div class="text-gray-500 dark:text-gray-400">
                            Nu există membri activi în această grupă.
                        </div>
                    @else
                        <div class="text-gray-500 dark:text-gray-400">
                            Selectează o grupă pentru a marca prezențele.
                        </div>
                    @endif
                </div>
            @else
                <div wire:key="view-tab-content">
                    <!-- Vizualizare Prezențe -->
                    <div class="space-y-6">
                        <!-- Filtre -->
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Perioada Start</label>
                                <input type="date" 
                                       wire:model.live="startDate"
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Perioada Sfârșit</label>
                                <input type="date" 
                                       wire:model.live="endDate"
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Grupă</label>
                                <select wire:model.live="selectedGroup"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                    <option value="">Toate grupele</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Membru</label>
                                <select wire:model.live="selectedMember"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                    <option value="">Toți membrii</option>
                                    @foreach($allMembers as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if($attendanceStats)
                            <!-- Tabel pentru Desktop -->
                            <div class="hidden overflow-x-auto md:block">
                                <table class="w-full">
                                    <thead>
                                        <tr class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase border-b dark:border-gray-700">
                                            <th class="p-4">Membru</th>
                                            <th class="p-4">Grupă</th>
                                            <th class="p-4">Total Prezențe</th>
                                            <th class="p-4">Detalii</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attendanceStats as $stat)
                                            <tr class="border-b dark:border-gray-700" wire:key="stat-{{ $stat['id'] }}">
                                                <td class="p-4 text-gray-900 dark:text-gray-100">
                                                    {{ $stat['name'] }}
                                                </td>
                                                <td class="p-4 text-gray-600 dark:text-gray-400">
                                                    {{ $stat['group'] }}
                                                </td>
                                                <td class="p-4 text-gray-600 dark:text-gray-400">
                                                    {{ $stat['total_attendances'] }}
                                                </td>
                                                <td class="p-4 text-gray-600 dark:text-gray-400">
                                                    <button @click="$dispatch('open-attendance-details', { dates: {{ json_encode($stat['attendance_dates']) }}, name: '{{ $stat['name'] }}' })"
                                                            class="text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300">
                                                        Vezi prezențe
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Cards pentru Mobile -->
                            <div class="space-y-4 md:hidden">
                                @foreach($attendanceStats as $stat)
                                    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-700" wire:key="mobile-stat-{{ $stat['id'] }}">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <h3 class="font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $stat['name'] }}
                                                </h3>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    {{ $stat['group'] }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $stat['total_attendances'] }}
                                                </div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400">
                                                    prezențe
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="pt-4 mt-4 border-t dark:border-gray-600">
                                            <button @click="$dispatch('open-attendance-details', { dates: {{ json_encode($stat['attendance_dates']) }}, name: '{{ $stat['name'] }}' })"
                                                    class="w-full py-2 text-center text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300">
                                                Vezi prezențe
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-gray-500 dark:text-gray-400">
                                Nu există date pentru filtrele selectate.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

   <!-- Modal pentru detalii prezențe -->
<div x-data="{ 
        show: false, 
        dates: [],
        memberName: '',
        formatDates() {
            return this.dates
                .sort((a, b) => new Date(a) - new Date(b))
                .map(date => {
                    const [year, month, day] = date.split('-');
                    return `${day}.${month}.${year}`;
                })
                .join(', ');
        }
    }"
     @open-attendance-details.window="
        show = true; 
        dates = $event.detail.dates;
        memberName = $event.detail.name"
     x-show="show"
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     style="background-color: rgba(0,0,0,0.5);">
    <div class="w-full max-w-lg p-6 mx-auto bg-white rounded-lg dark:bg-gray-800" @click.away="show = false">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100" x-text="'Prezențe - ' + memberName"></h3>
            <button @click="show = false" class="text-gray-400 hover:text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="mt-4 text-gray-600 dark:text-gray-400">
            <div x-show="dates.length > 0">
                <div class="mb-2 font-medium">Prezent în următoarele zile:</div>
                <div x-text="formatDates()"></div>
            </div>
            <div x-show="dates.length === 0" class="py-4 text-center">
                Nu există prezențe în perioada selectată.
            </div>
        </div>
    </div>
</div>