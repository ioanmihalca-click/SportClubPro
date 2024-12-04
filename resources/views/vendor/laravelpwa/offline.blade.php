<x-guest-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center">
                        <img class="w-auto h-24 mx-auto" src="{{ asset('assets/logo.webp') }}" alt="SportClubPro Logo">
                        <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                            Nu ești conectat la internet
                        </h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Verifică conexiunea la internet și încearcă din nou.
                        </p>
                    </div>
                    
                    <div class="mt-8">
                        <button onclick="window.location.reload()" 
                                class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-md shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            Reîncearcă
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>