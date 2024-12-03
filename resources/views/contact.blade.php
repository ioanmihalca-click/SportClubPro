<x-guest-layout>

    <div class="pb-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

         <!-- Header/Nav -->
        <header class="flex items-center justify-between w-full px-6 py-4 max-w-7xl">
            {{-- <div class="text-2xl font-bold text-teal-600 dark:text-teal-400">
                SportClubPro
            </div> --}}
            <a href="/">
                <img src="{{ asset('assets/logo.webp') }}" alt="SportClubPro Logo" class="w-auto h-16">
            </a>
            @if (Route::has('login'))
                <nav class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="font-semibold text-gray-700 hover:text-teal-600 dark:text-gray-300 dark:hover:text-teal-400">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="font-semibold text-gray-700 hover:text-teal-600 dark:text-gray-300 dark:hover:text-teal-400">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="font-semibold text-teal-600 hover:text-teal-500 dark:text-teal-400 dark:hover:text-teal-300">Înregistrare
                            </a>
                        @endif
                    @endauth
                    <livewire:theme-toggle />
                </nav>
            @endif
        </header>

            <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <livewire:contact-form />
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>