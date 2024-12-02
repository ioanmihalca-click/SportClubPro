// resources/views/livewire/create-club.blade.php
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="name">
                        Numele Clubului
                    </label>
                    <input 
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        id="name"
                        type="text"
                        wire:model="name"
                        required
                    >
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="address">
                        Adresa
                    </label>
                    <input 
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        id="address"
                        type="text"
                        wire:model="address"
                    >
                    @error('address') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="phone">
                        Telefon
                    </label>
                    <input 
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        id="phone"
                        type="text"
                        wire:model="phone"
                    >
                    @error('phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="email">
                        Email Club
                    </label>
                    <input 
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        id="email"
                        type="email"
                        wire:model="email"
                    >
                    @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="cif">
                        CIF/CUI
                    </label>
                    <input 
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        id="cif"
                        type="text"
                        wire:model="cif"
                    >
                    @error('cif') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-end">
                    <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline" type="submit">
                        Creează Club
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>