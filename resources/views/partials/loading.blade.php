<div id="preloader" class="fixed inset-0 z-50">
    <div class="absolute inset-0 bg-gradient-to-br from-[#0d9488] to-[#0891b2] dark:from-[#134e4a] dark:to-[#164e63]"></div>
    <div class="relative z-10 flex items-center justify-center h-screen">
        <div x-data x-cloak class="text-center loading-container">
            <img src="{{ asset('assets/logo.webp') }}" alt="SportClubPro Logo" class="w-32 h-32 mx-auto mb-5 animate-pulse">
            <div class="text-xl font-medium text-white">Se încarcă SportClubPro...</div>
            <div class="flex justify-center gap-2 mt-4">
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0s"></div>
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
            </div>
        </div>
    </div>
</div>