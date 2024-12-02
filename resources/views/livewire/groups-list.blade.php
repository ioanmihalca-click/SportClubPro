
<div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
    <!-- Formular Adăugare -->
    <div class="mb-8">
        <h3 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">Adaugă Grupă Nouă</h3>
        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nume Grupă</label>
                <input type="text" wire:model="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descriere</label>
                <textarea wire:model="description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" rows="3"></textarea>
                @error('description') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                Adaugă Grupă
            </button>
        </form>
    </div>

    <!-- Lista Grupe -->
    <div class="mt-6">
        <h3 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">Grupe Existente</h3>
        
        @if(session()->has('message'))
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                {{ session('message') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-4">
            @foreach($groups as $group)
                <div class="p-4 border rounded-lg dark:border-gray-700">
                    @if($editingGroupId === $group->id)
                        <form wire:submit.prevent="update" class="space-y-4">
                            <div>
                                <input type="text" wire:model="editingName" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                @error('editingName') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <textarea wire:model="editingDescription" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" rows="3"></textarea>
                                @error('editingDescription') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex space-x-2">
                                <button type="submit" class="px-3 py-1 text-sm font-bold text-white bg-green-500 rounded hover:bg-green-700">
                                    Salvează
                                </button>
                                <button wire:click="$set('editingGroupId', null)" class="px-3 py-1 text-sm font-bold text-white bg-gray-500 rounded hover:bg-gray-700">
                                    Anulează
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300">{{ $group->name }}</h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $group->description }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <button wire:click="edit({{ $group->id }})" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    Editează
                                </button>
                                <button wire:click="delete({{ $group->id }})" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                    Șterge
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>