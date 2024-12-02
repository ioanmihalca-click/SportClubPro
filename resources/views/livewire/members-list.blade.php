<div class="dark:bg-gray-800">
    <div class="flex flex-col mb-4 space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
        <!-- Search Bar -->
        <div class="flex-1">
            <input type="text" 
                   wire:model.debounce.300ms="search" 
                   placeholder="Caută membri..."
                   class="w-full border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        </div>
        
        <!-- Filters -->
        <div class="flex space-x-4">
            <select wire:model="activeFilter" class="border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="all">Toți membrii</option>
                <option value="active">Activi</option>
                <option value="inactive">Inactivi</option>
            </select>
            
            <select wire:model="groupFilter" class="border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Toate grupele</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Add Member Button -->
        <div>
            <a href="{{ route('members.create') }}" 
               class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-indigo-600 border border-transparent rounded-md dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25">
                Adaugă Membru
            </a>
        </div>
    </div>

    <!-- Members Table -->
    <div class="overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Nume</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Contact</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Grupă</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Tip Cotizație</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Status</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Acțiuni</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @foreach($members as $member)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $member->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ $member->email }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $member->phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ $member->group?->name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ $member->feeType?->name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $member->active ? 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900' : 'bg-red-100 text-red-800 dark:bg-red-200 dark:text-red-900' }}">
                                {{ $member->active ? 'Activ' : 'Inactiv' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                            <a href="{{ route('members.edit', $member) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                            <button wire:click="toggleStatus({{ $member->id }})" class="ml-3 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                                {{ $member->active ? 'Dezactivează' : 'Activează' }}
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
</div>