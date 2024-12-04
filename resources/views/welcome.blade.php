<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description"
        content="SportClubPro - Platformă gratuită pentru managementul cluburilor sportive. Gestionează membri, prezențe, plăți și evenimente.">
    <meta name="keywords"
        content="management club sportiv, administrare club sport, evidență membri, prezențe club, plăți club sportiv">
    <meta name="author" content="Click Studios Digital">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="SportClubPro - Management Club Sportiv">
    <meta property="og:description" content="Platformă gratuită pentru managementul cluburilor sportive">
    <meta property="og:image" content="{{ asset('assets/OG-sportclubpro.jpg') }}">

    <title>SportClubPro - Management pentru Clubul Tău Sportiv</title>

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="SportClubPro" />
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4375168668507865"
        crossorigin="anonymous"></script>

    <!-- Adăugăm markup schema.org -->
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "SportClubPro",
    "description": "Platformă gratuită pentru managementul cluburilor sportive",
    "applicationCategory": "BusinessApplication",
    "operatingSystem": "Web",
    "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "RON"
    },
    "creator": {
        "@type": "Organization",
        "name": "Click Studios Digital",
        "url": "https://clickstudios-digital.com"
    }
}
</script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MXVKPE4ZG1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-MXVKPE4ZG1');
    </script>

    @livewireStyles

</head>

<body class="font-sans antialiased">
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 dark:bg-black">
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

<!-- Hero Section -->
<main class="relative flex items-center flex-grow overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 z-0 opacity-55">
        <div class="absolute rounded-full left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[1200px] h-[1200px] bg-gradient-radial from-teal-100 via-blue-50/50 to-transparent blur-2xl dark:from-teal-900/50 dark:via-blue-900/30 dark:to-transparent"></div>
        <div class="absolute rounded-full left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[1000px] h-[1000px] bg-gradient-radial from-blue-50 via-teal-50/50 to-transparent blur-2xl dark:from-blue-900/50 dark:via-teal-900/30 dark:to-transparent"></div>
    </div>

    <div class="relative z-10 px-6 py-16 mx-auto max-w-7xl">
       <div class="grid items-center grid-cols-1 gap-12 lg:grid-cols-2">
           <!-- Left Column - Text -->
           <div class="space-y-8">

               <h1 class="text-4xl font-bold text-gray-900 lg:text-6xl dark:text-white">
                   Management Eficient pentru Clubul Tău Sportiv
               </h1>

               <p class="space-y-1 text-lg text-gray-600 dark:text-gray-400">
                   <span class="block font-medium">
                       Platformă gratuită pentru managementul cluburilor sportive.
                   </span>
                   <span class="block leading-relaxed">
                       Gestionează cu ușurință membrii, prezențele, plățile și evenimentele clubului tău. Soluție ideală pentru cluburi de arte marțiale, box, fotbal și alte sporturi.
                   </span>
               </p>

               <div class="pt-4">
                   <!-- CTA Buttons -->
                   <div class="flex flex-col gap-4 sm:flex-row">
                       <a href="{{ route('register') }}"
                           class="inline-flex items-center px-6 py-3 font-semibold text-white transition-colors bg-teal-600 rounded-lg shadow-lg hover:bg-teal-700">
                           Începe Gratuit
                           <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M14 5l7 7m0 0l-7 7m7-7H3" />
                           </svg>
                       </a>

                       <a href="{{ route('manual') }}"
                           class="inline-flex items-center px-6 py-3 font-semibold text-teal-600 transition-colors bg-white border-2 border-teal-600 rounded-lg shadow-lg hover:bg-teal-50 dark:bg-gray-800 dark:text-teal-400 dark:border-teal-400 dark:hover:bg-gray-700">
                           Vezi Manualul
                           <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                           </svg>
                       </a>
                   </div>
               </div>

               <!-- Banner principal AdSense -->
               {{-- <div class="w-full py-8 bg-white dark:bg-gray-800">
                   <div class="px-4 mx-auto max-w-7xl">
                       <div
                           class="flex items-center justify-center w-full h-24 bg-gray-100 rounded-lg dark:bg-gray-700">
                           <ins class="adsbygoogle" style="display:block" data-ad-format="fluid"
                               data-ad-layout-key="-6t+ed+2i-1n-4w" data-ad-client="ca-pub-4375168668507865"
                               data-ad-slot="2732792975"></ins>
                       </div>
                   </div>
               </div> --}}

           </div>



                    <!-- Right Column - Features -->
                    <div class="grid gap-6">
                        <!-- Feature 1 -->
                        <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
                            <!-- Feature Icons -->
                            <div class="mb-4 text-teal-600 dark:text-teal-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Management Membri</h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">Gestionează cu ușurință membrii clubului,
                                prezențele și plățile.</p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
                            <!-- Feature Icons -->
                            <div class="mb-4 text-teal-600 dark:text-teal-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Rapoarte și Statistici</h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">Rapoarte PDF detaliate și statistici
                                pentru
                                o mai bună înțelegere a activității clubului.</p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
                            <!-- Feature Icons -->
                            <div class="mb-4 text-teal-600 dark:text-teal-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Evenimente și Competiții
                            </h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">Gestionează evenimente, competiții și
                                rezultate cu ușurință.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <x-footer />

    </div>

    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

    @livewireScripts
</body>

</html>
