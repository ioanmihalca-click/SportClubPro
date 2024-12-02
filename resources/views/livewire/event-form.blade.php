
<div class="p-6 space-y-6 bg-white rounded-lg shadow dark:bg-gray-800">
    <form wire:submit="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Nume Eveniment
            </label>
            <input type="text" 
                   wire:model="name"
                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
            @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Data
            </label>
            <input type="date" 
                   wire:model="date"
                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
            @error('date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Tip Eveniment
            </label>
            <select wire:model="type"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                <option value="">Selectează tipul</option>
                @foreach($eventTypes as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            @error('type') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Detalii
            </label>
            <textarea wire:model="details"
                      rows="3"
                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"></textarea>
            @error('details') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('events.index') }}"
               class="px-4 py-2 font-bold text-gray-800 bg-gray-300 rounded dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 dark:text-gray-200">
                Anulează
            </a>
            <button type="submit"
                    class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                {{ $isEdit ? 'Actualizează' : 'Adaugă' }} Eveniment
            </button>
        </div>
    </form>
</div>