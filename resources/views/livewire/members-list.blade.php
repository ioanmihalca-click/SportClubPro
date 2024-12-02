<div class="dark:bg-gray-800">
    <div class="flex flex-col mb-4 space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
        <!-- Search Bar -->
        <div class="flex-1">
            <input type="text" wire:model.debounce.300ms="search" placeholder="Caută membri..."
                class="w-full border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        </div>

        <!-- Filters -->
        <div class="flex space-x-4">
            <select wire:model="activeFilter"
                class="border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="all">Toți membrii</option>
                <option value="active">Activi</option>
                <option value="inactive">Inactivi</option>
            </select>

            <select wire:model="groupFilter"
                class="border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Toate grupele</option>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>

         <!-- Action Buttons -->
        <div class="flex space-x-2">
            <a href="{{ route('members.create') }}" 
               class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                Adaugă Membru
            </a>
            <a href="{{ route('reports.members') }}" 
               class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                Export Membri PDF
            </a>
            <button 
                x-data
                x-on:click="$dispatch('open-financial-modal')"
                class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                Raport Financiar
            </button>
        </div>
    </div>

    <!-- Members Table -->
    <div class="overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        Nume</th>
                    <th
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        Contact</th>
                    <th
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        Grupă</th>
                    <th
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        Tip Cotizație</th>
                    <th
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        Status</th>
                    <th
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        Acțiuni</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @foreach ($members as $member)
                    <tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $member->email }}</div>
                            <div class="text-sm text-gray-500">{{ $member->phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $member->group ? $member->group->name : '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $member->feeType ? $member->feeType->name : '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $member->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $member->active ? 'Activ' : 'Inactiv' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                            <a href="{{ route('members.edit', $member) }}"
                                class="mr-3 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                Edit
                            </a>
                            <button wire:click="toggleStatus({{ $member->id }})"
                                class="mr-3 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                {{ $member->active ? 'Dezactivează' : 'Activează' }}
                            </button>
                            <button x-data
                                x-on:click="$dispatch('open-delete-modal', { memberId: {{ $member->id }} })"
                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                Șterge
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        

        <div class="p-4 dark:bg-gray-800">
            {{ $members->links() }}
        </div>
    </div>

    <!-- Modal de confirmare la sfârșitul componentei -->
    <div x-data="{
        showDeleteModal: false,
        memberToDelete: null,
        openModal(memberId) {
            this.memberToDelete = memberId;
            this.showDeleteModal = true;
        }
    }" @open-delete-modal.window="openModal($event.detail.memberId)">
        <div x-show="showDeleteModal" class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                <div
                    class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="px-4 pt-5 pb-4 bg-white dark:bg-gray-800 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100"
                                    id="modal-title">
                                    Confirmare ștergere
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Sunteți sigur că doriți să ștergeți acest membru? Această acțiune nu poate fi
                                        anulată.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="deleteMember(memberToDelete)"
                            @click="showDeleteModal = false"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Șterge
                        </button>
                        <button type="button" @click="showDeleteModal = false"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Anulează
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pentru raport financiar -->
<div x-data="{ 
    showModal: false,
    monthNames: ['Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'Mai', 'Iunie', 'Iulie', 'August', 'Septembrie', 'Octombrie', 'Noiembrie', 'Decembrie']
}"
    x-on:open-financial-modal.window="showModal = true">
    
    <div x-show="showModal" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

    <div x-show="showModal" class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-center justify-center min-h-full p-4">
            <div class="w-full max-w-md px-4 py-6 bg-white rounded-lg dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                    Generare Raport Financiar
                </h3>

                <form action="{{ route('reports.financial') }}" method="GET">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Luna</label>
                            <select name="month" class="block w-full mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ now()->month == $i ? 'selected' : '' }}>
                                        {{ Carbon\Carbon::create()->month($i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Anul</label>
                            <select name="year" class="block w-full mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                @for($i = now()->year; $i >= now()->year - 5; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button"
                                x-on:click="showModal = false"
                                class="px-4 py-2 font-bold text-gray-800 bg-gray-300 rounded dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 dark:text-gray-200">
                            Anulează
                        </button>
                        <button type="submit"
                                class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                            Generează Raport
                        </button>
                    </div>
                </form>
            </div>
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
