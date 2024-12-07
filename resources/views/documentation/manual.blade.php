<x-guest-layout>
    <div class="pb-12">
        <div class="p-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
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

              <!-- Video Section -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="mb-6 text-2xl font-bold text-center text-gray-900 dark:text-gray-100">
                        Tutorial Video SportClubPro
                    </h2>
                    <div class="relative w-full overflow-hidden pt-[56.25%]">
                        <iframe 
                            class="absolute top-0 left-0 w-full h-full rounded-lg"
                            src="https://www.youtube.com/embed/sFqTWM3xVLA"
                            title="Tutorial SportClubPro"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>

                <div class="p-6 space-y-8">
                    <!-- Table of Contents -->
                    <div class="mb-8">
                        <h3 class="mb-4 text-lg font-semibold">Cuprins</h3>
                        <ul class="space-y-2">
                            @foreach($manual['sections'] as $section)
                                <li>
                                    <a href="#{{ Str::slug($section['title']) }}" 
                                       class="text-teal-600 dark:text-teal-400 hover:underline">
                                        {{ $section['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Content -->
                    @foreach($manual['sections'] as $section)
                        <div id="{{ Str::slug($section['title']) }}" class="mb-12">
                            <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $section['title'] }}
                            </h2>
                            
                            @foreach($section['content'] as $title => $content)
                                <div class="mb-6">
                                    <h3 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $title }}
                                    </h3>
                                    
                                    @if(is_array($content))
    <ul class="space-y-2 text-gray-600 list-disc list-inside dark:text-gray-400">
        @foreach($content as $key => $item)
            @if(is_array($item) && isset($item['url']))
                <li>
                    <a href="{{ $item['url'] }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="text-teal-600 hover:text-teal-900 dark:text-teal-400 dark:hover:text-teal-300">
                        {{ $item['text'] }}
                    </a>
                </li>
            @else
                <li>{{ is_array($item) ? $item['text'] : $item }}</li>
            @endif
        @endforeach
    </ul>
@else
    <p class="text-gray-600 dark:text-gray-400">{{ $content }}</p>
@endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <!-- Footer -->
                    <div class="pt-8 mt-12 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Versiune: {{ $manual['version'] }} | Ultima actualizare: {{ $manual['last_updated'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>