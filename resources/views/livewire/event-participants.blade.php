
<div class="p-6 space-y-6 bg-white rounded-lg shadow dark:bg-gray-800">
    @if(session()->has('message'))
        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
        Participanți {{ $event->name }}
    </h2>
    
    <a href="{{ route('reports.event-results', $event->id) }}"
       class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
        Export Rezultate PDF
    </a>
</div>

    <div class="mb-4">
        <input type="text"
               wire:model.live="search"
               placeholder="Caută membri..."
               class="w-full border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
    </div>

    <form wire:submit="save" class="space-y-4">
        <div class="border rounded-lg dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Participant
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Participă
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Rezultat
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @foreach($members as $member)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $member->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox"
                                       wire:model="participants.{{ $member->id }}"
                                       class="text-indigo-600 border-gray-300 rounded shadow-sm dark:border-gray-600">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(isset($participants[$member->id]))
                                    <input type="text"
                                           wire:model="results.{{ $member->id }}"
                                           placeholder="Introdu rezultatul"
                                           class="w-full border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('events.index') }}" 
               class="px-4 py-2 font-bold text-gray-800 bg-gray-300 rounded dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 dark:text-gray-200">
                Înapoi
            </a>
            <button type="submit"
                    class="px-4 py-2 font-bold text-white bg-teal-500 rounded hover:bg-teal-700">
                Salvează Participanți
            </button>
        </div>
    </form>
</div>