
<footer class="w-full py-8 bg-white dark:bg-gray-800">
    <div class="px-6 mx-auto max-w-7xl">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <!-- Logo & Description -->
            <div>
                <img src="{{ asset('assets/logo.webp') }}" alt="SportClubPro Logo" class="h-12 mb-4">
                <p class="text-gray-600 dark:text-gray-400">
                    Platformă gratuită pentru managementul cluburilor sportive.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Link-uri Utile</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('manual') }}" class="text-gray-600 hover:text-teal-600 dark:text-gray-400 dark:hover:text-teal-400">
                            Manual Utilizare
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-gray-600 hover:text-teal-600 dark:text-gray-400 dark:hover:text-teal-400">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Legal</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="/terms-of-service" class="text-gray-600 hover:text-teal-600 dark:text-gray-400 dark:hover:text-teal-400">
                            Termeni și Condiții
                        </a>
                    </li>
                    <li>
                        <a href="/privacy-policy" class="text-gray-600 hover:text-teal-600 dark:text-gray-400 dark:hover:text-teal-400">
                            Politica de Confidențialitate
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 mt-8 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col items-center justify-between space-y-4 md:flex-row md:space-y-0">
                <div class="text-sm text-gray-500 md:text-base dark:text-gray-400">
                    © {{ date('Y') }} SportClubPro. Toate drepturile rezervate.
                </div>
                <div class="text-gray-500 dark:text-gray-400">
                    Dezvoltat de 
                    <a href="https://clickstudios-digital.com" target="_blank" rel="noopener noreferrer"
                        class="text-teal-600 hover:text-teal-800 dark:text-teal-400 dark:hover:text-teal-300">
                        Click Studios Digital
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>