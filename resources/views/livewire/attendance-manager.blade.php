
<div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
    @if(session()->has('message'))
        <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
            {{ session('message') }}
        </div>
    @endif

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
                    <div class="flex items-center">
                        <input type="checkbox"
                               wire:model="attendees.{{ $member->id }}"
                               class="text-indigo-600 border-gray-300 rounded shadow-sm dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <label class="ml-2 text-gray-700 dark:text-gray-300">{{ $member->name }}</label>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
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