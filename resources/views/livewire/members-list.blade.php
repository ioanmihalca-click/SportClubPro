<div class="p-4 dark:bg-gray-800">
    <!-- Notifications -->
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-teal-700 bg-teal-100 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

     <!-- Action Dropdown for Mobile -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="w-full p-3 mb-3 text-left text-white bg-teal-600 rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                <span>Acțiuni</span>
                <svg class="inline-block w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.away="open = false"
                class="absolute z-50 w-full mt-2 bg-white rounded-md shadow-lg dark:bg-gray-700">
                <a href="{{ route('members.create') }}"
                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600">
                    Adaugă Membru
                </a>
                <a href="{{ route('reports.members') }}"
                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600">
                    Export Membri PDF
                </a>
                <button @click="$dispatch('open-financial-modal')"
                    class="w-full px-4 py-3 text-sm text-left text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600">
                    Raport Financiar
                </button>
            </div>
        </div>

    <!-- Search and Filters Section - Stacked on mobile -->
    <div class="space-y-4">
        <!-- Search Bar -->
        <div class="w-full">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Caută membri..."
                class="w-full p-3 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">

        </div>

        <!-- Filters - Full width on mobile -->
        <div class="space-y-3 sm:space-y-0 sm:flex sm:space-x-3">
            <select wire:model="activeFilter"
                class="w-full p-3 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                <option value="all">Toți membrii</option>
                <option value="active">Activi</option>
                <option value="inactive">Inactivi</option>
            </select>

            <select wire:model="groupFilter"
                class="w-full p-3 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                <option value="">Toate grupele</option>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>

       
    </div>

  
    <!-- Members Cards Grid -->
    <div class="mt-6 space-y-4">
        @foreach ($members as $member)
            <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ $loop->iteration }}. {{ $member->name }}
                        </h3>
                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $member->email }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $member->phone }}
                        </div>
                    </div>
                    <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $member->active ? 'bg-teal-100 text-teal-800' : 'bg-red-100 text-red-800' }}">
                        {{ $member->active ? 'Activ' : 'Inactiv' }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Grupă</span>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $member->group ? $member->group->name : '-' }}
                        </p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tip Cotizație</span>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $member->feeType ? $member->feeType->name : '-' }}
                        </p>
                    </div>
                </div>

                <div class="flex justify-end mt-4 space-x-3">
                    <a href="{{ route('members.edit', $member) }}"
                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                        Edit
                    </a>
                    <button wire:click="toggleStatus({{ $member->id }})"
                        class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                        {{ $member->active ? 'Dezactivează' : 'Activează' }}
                    </button>
                    <button x-data x-on:click="$dispatch('open-delete-modal', { memberId: {{ $member->id }} })"
                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                        Șterge
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $members->links() }}
    </div>


    <!-- Modal de confirmare ștergere -->
    <div x-data="{
        showDeleteModal: false,
        memberToDelete: null,
        openModal(memberId) {
            this.memberToDelete = memberId;
            this.showDeleteModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.showDeleteModal = false;
            document.body.style.overflow = '';
        }
    }" @open-delete-modal.window="openModal($event.detail.memberId)"
        @keydown.escape.window="closeModal()">

        <!-- Backdrop -->
        <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-gray-500 bg-opacity-75">
        </div>

        <!-- Modal -->
        <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-full"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-full"
            class="fixed inset-0 z-50 overflow-y-auto md:overflow-visible" @click.self="closeModal()">

            <div class="flex min-h-screen text-center md:block md:p-0">
                <div
                    class="w-full min-h-screen transition-all transform md:min-h-0 md:inline-block md:overflow-hidden md:max-w-lg md:my-8 md:align-middle md:w-full">
                    <!-- Modal content -->
                    <div class="w-full h-full text-left bg-white shadow-xl md:h-auto dark:bg-gray-800 md:rounded-lg">
                        <!-- Header cu buton de închidere -->
                        <div
                            class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Confirmare ștergere
                            </h3>
                            <button @click="closeModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <span class="sr-only">Închide</span>
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Conținut -->
                        <div class="px-4 py-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Sunteți sigur că doriți să ștergeți acest membru? Această acțiune nu poate fi anulată.
                            </p>
                        </div>

                        <!-- Footer cu acțiuni -->
                        <div
                            class="flex flex-col-reverse px-4 py-3 bg-gray-50 dark:bg-gray-700 sm:px-6 sm:flex-row sm:justify-end sm:space-x-2">
                            <button type="button" @click="closeModal()"
                                class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm sm:mt-0 sm:w-auto hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                Anulează
                            </button>
                            <button type="button" wire:click="deleteMember(memberToDelete)" @click="closeModal()"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm sm:w-auto hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Șterge
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pentru raport financiar -->
    <div x-cloak x-data="{
        showModal: false,
        monthNames: ['Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'Mai', 'Iunie', 'Iulie', 'August', 'Septembrie', 'Octombrie', 'Noiembrie', 'Decembrie'],
        openModal() {
            this.showModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.showModal = false;
            document.body.style.overflow = '';
        }
    }" @open-financial-modal.window="openModal()" @keydown.escape.window="closeModal()">

        <!-- Backdrop -->
        <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-gray-500 bg-opacity-75">
        </div>

        <!-- Modal -->
        <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-full"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-full"
            class="fixed inset-0 z-50 overflow-y-auto md:overflow-visible" @click.self="closeModal()">

            <div class="flex min-h-screen text-center md:block md:p-0">
                <div
                    class="w-full min-h-screen transition-all transform md:min-h-0 md:inline-block md:overflow-hidden md:max-w-lg md:my-8 md:align-middle md:w-full">
                    <div class="w-full h-full text-left bg-white shadow-xl md:h-auto dark:bg-gray-800 md:rounded-lg">
                        <!-- Header -->
                        <div
                            class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Generare Raport Financiar
                            </h3>
                            <button @click="closeModal()"
                                class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <span class="sr-only">Închide</span>
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Form content -->
                        <form action="{{ route('reports.financial') }}" method="GET" class="p-4">
                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Luna</label>
                                    <select name="month"
                                        class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:border-teal-500 focus:outline-none focus:ring-teal-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}"
                                                {{ now()->month == $i ? 'selected' : '' }}>
                                                {{ Carbon\Carbon::create()->month($i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Anul</label>
                                    <select name="year"
                                        class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:border-teal-500 focus:outline-none focus:ring-teal-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                        @for ($i = now()->year; $i >= now()->year - 5; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <!-- Footer actions -->
                            <div class="flex flex-col-reverse mt-6 sm:flex-row sm:justify-end sm:space-x-2">
                                <button type="button" @click="closeModal()"
                                    class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm sm:mt-0 sm:w-auto hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                    Anulează
                                </button>
                                <button type="submit"
                                    class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-teal-600 border border-transparent rounded-md shadow-sm sm:w-auto hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                    Generează Raport
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            window.addEventListener('livewire:load', function() {
                Livewire.on('confirmDelete', data => {
                    window.dispatchEvent(new CustomEvent('confirm-delete', {
                        detail: data.id
                    }));
                });
            });
        </script>
    </div>
