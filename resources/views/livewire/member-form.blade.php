<div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nume</label>
            <input type="text" wire:model="name"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
            @error('name')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" wire:model="email"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
            @error('email')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefon</label>
            <input type="text" wire:model="phone"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
            @error('phone')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data nașterii</label>
            <input type="date" wire:model="birth_date"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
            @error('birth_date')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adresă</label>
            <textarea wire:model="address"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
                rows="3"></textarea>
            @error('address')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Note medicale</label>
            <textarea wire:model="medical_notes"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
                rows="3"></textarea>
            @error('medical_notes')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Grupă</label>
            <select wire:model="group_id"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                <option value="">Selectează grupa</option>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
            @error('group_id')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tip Cotizație</label>
            <select wire:model="fee_type_id"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                <option value="">Selectează tipul de cotizație</option>
                @foreach ($feeTypes as $feeType)
                    <option value="{{ $feeType->id }}">{{ $feeType->name }} - {{ $feeType->amount }} RON</option>
                @endforeach
            </select>
            @error('fee_type_id')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-teal-600 border border-transparent rounded-md dark:bg-teal-500 hover:bg-teal-700 dark:hover:bg-teal-600 active:bg-teal-900 focus:outline-none focus:border-teal-900 focus:ring focus:ring-teal-300 disabled:opacity-25">
                {{ $isEdit ? 'Actualizează' : 'Adaugă' }} Membru
            </button>
        </div>
    </form>
</div>
