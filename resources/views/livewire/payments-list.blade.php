
<div class="space-y-6">
    @if(session()->has('message'))
        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Add Payment Form -->
    <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
        <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
            Înregistrare Plată Nouă
        </h3>

        <form wire:submit="savePayment" class="space-y-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Membru</label>
                    <select wire:model="memberId" class="block w-full mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        <option value="">Selectează membru</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                    @error('memberId') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tip Cotizație</label>
                    <select wire:model="feeTypeId" class="block w-full mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        <option value="">Selectează tip cotizație</option>
                        @foreach($feeTypes as $feeType)
                            <option value="{{ $feeType->id }}">{{ $feeType->name }} - {{ $feeType->amount }} RON</option>
                        @endforeach
                    </select>
                    @error('feeTypeId') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sumă</label>
                    <input type="number" step="0.01" wire:model="amount" 
                           class="block w-full mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                    @error('amount') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data Plății</label>
                    <input type="date" wire:model="paymentDate" 
                           class="block w-full mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                    @error('paymentDate') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Note</label>
                <textarea wire:model="notes" rows="2"
                          class="block w-full mt-1 border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"></textarea>
                @error('notes') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                    Înregistrează Plata
                </button>
            </div>
        </form>
    </div>

    <!-- Search -->
    <div class="mb-4">
        <input type="text" 
               wire:model.live="search" 
               placeholder="Caută după numele membrului..."
               class="w-full border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
    </div>

    <!-- Payments List -->
    <div class="overflow-hidden bg-white shadow dark:bg-gray-800 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        Data
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        Membru
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        Tip Cotizație
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        Sumă
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        Note
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        Acțiuni
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @foreach($payments as $payment)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-gray-100">
                            {{ $payment->payment_date->format('d.m.Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-gray-100">
                            {{ $payment->member->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-gray-100">
                            {{ $payment->feeType->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-gray-100">
                            {{ number_format($payment->amount, 2) }} RON
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                            {{ $payment->notes }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-gray-100">
                            <button wire:click="deletePayment({{ $payment->id }})"
                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                Șterge
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $payments->links() }}
        </div>
    </div>
</div>