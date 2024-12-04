<div class="p-4 space-y-6">
    <!-- Notifications -->
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Add Payment Form -->
    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
        <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
            Înregistrare Plată Nouă
        </h3>

        <form wire:submit="savePayment" class="space-y-4">
            <!-- Form fields stacked on mobile -->
            <div class="space-y-4 md:grid md:grid-cols-2 md:gap-4 md:space-y-0">
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Membru</label>
                    <input type="text" wire:model.live="searchMember" placeholder="Caută membru..."
                        class="w-full p-3 mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">

                    @if (!empty($filteredMembers))
                        <div class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg dark:bg-gray-700">
                            <ul class="py-1 overflow-auto max-h-60">
                                @foreach ($filteredMembers as $member)
                                    <li wire:click="selectMember({{ $member->id }})"
                                        class="px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                                        {{ $member->name }}
                                        @if ($member->group)
                                            <span class="block text-sm text-gray-500 dark:text-gray-400">
                                                {{ $member->group->name }}
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tip Cotizație</label>
                    <select wire:model="feeTypeId"
                        class="w-full p-3 mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        <option value="">Selectează tip cotizație</option>
                        @foreach ($feeTypes as $feeType)
                            <option value="{{ $feeType->id }}">
                                {{ $feeType->name }} - {{ $feeType->amount }} RON
                            </option>
                        @endforeach
                    </select>
                    @error('feeTypeId')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sumă</label>
                    <input type="number" step="0.01" wire:model="amount"
                        class="w-full p-3 mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                    @error('amount')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data Plății</label>
                    <input type="date" wire:model="paymentDate"
                        class="w-full p-3 mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                    @error('paymentDate')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Note</label>
                <textarea wire:model="notes" rows="2"
                    class="w-full p-3 mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"></textarea>
                @error('notes')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="w-full px-6 py-3 font-bold text-white transition-colors bg-teal-500 rounded-md sm:w-auto hover:bg-teal-700">
                    Înregistrează Plata
                </button>
            </div>
        </form>
    </div>

    <!-- Search -->
    <div>
        <input type="text" wire:model.live="search" placeholder="Caută după numele membrului..."
            class="w-full p-3 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
    </div>

    <!-- Payments Cards -->
    <div class="space-y-4">
        @foreach ($payments as $payment)
            <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Header cu data și sumă -->
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration }}.
                            {{ $payment->member->name }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $payment->payment_date->format('d.m.Y') }}
                        </div>
                    </div>
                    <div class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ number_format($payment->amount, 2) }} RON
                    </div>
                </div>

                <!-- Detalii plată -->
                <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tip Cotizație</span>
                        <p class="text-gray-900 dark:text-gray-100">
                            {{ $payment->feeType->name }}
                        </p>
                    </div>
                    @if ($payment->notes)
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Note</span>
                            <p class="text-gray-900 dark:text-gray-100">
                                {{ $payment->notes }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex justify-end">
                    <button wire:click="deletePayment({{ $payment->id }})"
                        class="text-red-600 transition-colors hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                        Șterge
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $payments->links() }}
    </div>
</div>
