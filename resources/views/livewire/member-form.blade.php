<div class="p-6 rounded-lg dark:bg-gray-800">
    <form wire:submit.prevent="save" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nume</label>
            <input type="text" 
                   wire:model.defer="member.name"
                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('member.name') <span class="text-xs text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email (optional)</label>
            <input type="email" 
                   wire:model.defer="member.email"
                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('member.email') <span class="text-xs text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefon</label>
            <input type="text" 
                   wire:model.defer="member.phone"
                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('member.phone') <span class="text-xs text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data nașterii</label>
            <input type="date" 
                   wire:model.defer="member.birth_date"
                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('member.birth_date') <span class="text-xs text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adresă</label>
            <textarea wire:model.defer="member.address"
                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                      rows="3"></textarea>
            @error('member.address') <span class="text-xs text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Note medicale</label>
            <textarea wire:model.defer="member.medical_notes"
                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                      rows="3"></textarea>
            @error('member.medical_notes') <span class="text-xs text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Grupă</label>
            <select wire:model.defer="member.group_id"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Selectează grupa</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
            @error('member.group_id') <span class="text-xs text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tip Cotizație</label>
            <select wire:model.defer="member.fee_type_id"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Selectează tipul de cotizație</option>
                @foreach($feeTypes as $feeType)
                    <option value="{{ $feeType->id }}">{{ $feeType->name }} - {{ $feeType->amount }} RON</option>
                @endforeach
            </select>
            @error('member.fee_type_id') <span class="text-xs text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-indigo-600 border border-transparent rounded-md dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25">
                {{ $isEdit ? 'Actualizează' : 'Adaugă' }} Membru
            </button>
        </div>
    </form>
</div>