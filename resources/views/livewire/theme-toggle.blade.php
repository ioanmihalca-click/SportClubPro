<div x-cloak x-data="{ 
    darkMode: false,
    init() {
        // Check initial theme
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            this.darkMode = true;
            document.documentElement.classList.add('dark');
        } else {
            this.darkMode = false;
            document.documentElement.classList.remove('dark');
        }

        // Listen for theme changes
        this.$watch('darkMode', value => {
            localStorage.theme = value ? 'dark' : 'light';
            document.documentElement.classList.toggle('dark', value);
        });
    }
}" class="relative">
    <button 
    @click="darkMode = !darkMode"
    type="button" 
    class="relative inline-flex items-center justify-center p-2 transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"
>
    <span class="sr-only">Toggle dark mode</span>
    <svg x-show="!darkMode" class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
    </svg>
    <svg x-show="darkMode" class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
    </svg>
</button>
</div>