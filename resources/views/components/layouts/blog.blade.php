<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- SEO Meta Tags --}}
    <title>{{ $seoTitle ?? 'Blog SportClubPro - Management pentru Cluburi Sportive' }}</title>
    <meta name="description" content="{{ $seoDescription ?? 'Articole despre management sportiv și administrarea cluburilor sportive' }}">
    
    {{-- Open Graph Meta Tags --}}
    <meta property="og:site_name" content="SportClubPro">
    <meta property="og:title" content="{{ $seoTitle ?? 'Blog SportClubPro' }}">
    <meta property="og:description" content="{{ $seoDescription ?? 'Articole despre management sportiv și administrarea cluburilor sportive' }}">
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage ?? url('images/default-og-image.jpg') }}">
    <meta property="og:locale" content="ro_RO">
    
    @if($ogType ?? '' == 'article')
        <meta property="article:published_time" content="{{ $ogPublishTime ?? '' }}">
        <meta property="article:modified_time" content="{{ $ogModifiedTime ?? '' }}">
        @if(isset($post) && $post->category)
            <meta property="article:section" content="{{ $post->category->name }}">
        @endif
    @endif
    
    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle ?? 'Blog SportClubPro' }}">
    <meta name="twitter:description" content="{{ $seoDescription ?? 'Articole despre management sportiv și administrarea cluburilor sportive' }}">
    <meta name="twitter:image" content="{{ $ogImage ?? url('images/default-og-image.jpg') }}">
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">
    
      <!-- Favicons -->
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="SportClubPro" />
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}" />

    <script>
        // Immediately invoked function to set the theme mode before page load
        (function() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-gray-100 dark:bg-gray-900">
    <!-- Header -->
    <header class="bg-white shadow dark:bg-gray-800">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo și Titlu -->
                <div class="flex">
                    <div class="flex items-center">
                        <a href="{{ route('blog.index') }}" class="text-2xl font-bold text-gray-900 dark:text-white">
                            Blog SportClubPro
                        </a>
                    </div>
                </div>

                <!-- Navigare -->
                <div class="hidden sm:flex sm:items-center sm:space-x-8">

                    <div class="relative ms-3">
                        <livewire:theme-toggle />
                    </div>

                    <a href="{{ route('blog.index') }}"
                        class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                        Toate Articolele
                    </a>
                    <a href="/"
                        class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                        Înapoi la Site
                    </a>
                </div>

                <!-- Mobile menu button -->

                <div class="flex items-center sm:hidden">

                    <div class="me-2">
                        <livewire:theme-toggle />
                    </div>

                    <button type="button"
                        class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white" x-data
                        @click="$dispatch('toggle-mobile-menu')">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="sm:hidden" x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open" x-cloak>
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('blog.index') }}"
                    class="block px-3 py-2 text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                    Toate Articolele
                </a>
                <a href="/"
                    class="block px-3 py-2 text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                    Înapoi la Site
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="px-4 mb-4 sm:px-0">
            {{ $breadcrumbs ?? '' }}
        </div>

        <!-- Content -->
        <div class="px-4 sm:px-0">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
   <x-footer />
</body>

</html>
