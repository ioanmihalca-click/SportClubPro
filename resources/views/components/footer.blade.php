<footer class="relative w-full py-16 overflow-hidden bg-gradient-to-br from-gray-100 to-white dark:from-gray-900 dark:to-gray-800">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Decorative background element -->
        <div class="absolute inset-0 z-0 opacity-40 dark:opacity-20">
            <div class="absolute rounded-full -right-24 -top-24 w-96 h-96 bg-teal-50 blur-3xl dark:bg-teal-900/30"></div>
            <div class="absolute rounded-full -left-24 -bottom-24 w-96 h-96 bg-blue-50 blur-3xl dark:bg-blue-900/30"></div>
        </div>

        <!-- Main content -->
        <div class="relative z-10">
            <!-- Top section -->
            <div class="grid gap-16 mb-16 md:grid-cols-2 lg:grid-cols-3">
                <!-- Logo & Description -->
                <div class="space-y-6">
                    <img src="{{ asset('assets/logo.webp') }}" alt="SportClubPro Logo" 
                         class="w-auto h-12 transition-transform duration-300 transform hover:scale-105">
                    <p class="max-w-md text-base leading-relaxed text-gray-600 dark:text-gray-400">
                        Platformă gratuită pentru managementul cluburilor sportive.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="space-y-6">
                    <h3 class="text-sm font-medium tracking-wider text-gray-900 uppercase dark:text-gray-100">
                        Link-uri Utile
                    </h3>
                    <ul class="space-y-4">
                        <li>
                            <a href="{{ route('manual') }}" 
                               class="flex items-center text-gray-600 transition-all duration-300 group hover:text-teal-600 dark:text-gray-400 dark:hover:text-teal-400">
                                <span class="w-0 h-px mr-0 transition-all duration-300 bg-teal-600 group-hover:w-2 dark:bg-teal-400 group-hover:mr-2"></span>
                                <span class="text-base">Manual Utilizare</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" 
                               class="flex items-center text-gray-600 transition-all duration-300 group hover:text-teal-600 dark:text-gray-400 dark:hover:text-teal-400">
                                <span class="w-0 h-px mr-0 transition-all duration-300 bg-teal-600 group-hover:w-2 dark:bg-teal-400 group-hover:mr-2"></span>
                                <span class="text-base">Contact</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Legal -->
                <div class="space-y-6">
                    <h3 class="text-sm font-medium tracking-wider text-gray-900 uppercase dark:text-gray-100">
                        Legal
                    </h3>
                    <ul class="space-y-4">
                        <li>
                            <a href="/terms-of-service" 
                               class="flex items-center text-gray-600 transition-all duration-300 group hover:text-teal-600 dark:text-gray-400 dark:hover:text-teal-400">
                                <span class="w-0 h-px mr-0 transition-all duration-300 bg-teal-600 group-hover:w-2 dark:bg-teal-400 group-hover:mr-2"></span>
                                <span class="text-base">Termeni și Condiții</span>
                            </a>
                        </li>
                        <li>
                            <a href="/privacy-policy" 
                               class="flex items-center text-gray-600 transition-all duration-300 group hover:text-teal-600 dark:text-gray-400 dark:hover:text-teal-400">
                                <span class="w-0 h-px mr-0 transition-all duration-300 bg-teal-600 group-hover:w-2 dark:bg-teal-400 group-hover:mr-2"></span>
                                <span class="text-base">Politica de Confidențialitate</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom section -->
            <div class="pt-8 border-t border-gray-200 dark:border-gray-700/50">
                <div class="flex flex-col items-center justify-between space-y-4 md:flex-row md:space-y-0">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        © {{ date('Y') }} SportClubPro. Toate drepturile rezervate.
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Dezvoltat de 
                        <a href="https://clickstudios-digital.com" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="relative inline-flex items-center font-medium text-teal-600 transition-colors duration-300 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 group">
                            Click Studios Digital
                            <span class="absolute bottom-0 left-0 w-0 h-px transition-all duration-300 bg-current group-hover:w-full"></span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>