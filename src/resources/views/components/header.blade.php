<header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="flex items-center">
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">CamUp</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ url('/') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 text-sm font-medium transition">
                    Início
                </a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 text-sm font-medium transition">
                        Dashboard
                    </a>
                @endauth
            </nav>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                <!-- Dark Mode Toggle -->
                <button 
                    x-data="{ 
                        darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                        toggle() {
                            this.darkMode = !this.darkMode;
                            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                            if (this.darkMode) {
                                document.documentElement.classList.add('dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                            }
                        }
                    }" 
                    @click="toggle()" 
                    class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg focus:outline-none"
                    title="Toggle Dark Mode"
                >
                    <!-- Sun Icon (showing in Dark Mode) -->
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <!-- Moon Icon (showing in Light Mode) -->
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                            <span class="text-sm font-medium">{{ optional(Auth::user())->name ?? 'Usuário' }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700">
                            <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Perfil
                            </a>
                            <a href="{{ url('/settings') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Configurações
                            </a>
                            <hr class="my-1 border-gray-200 dark:border-gray-700">
                            <form method="POST" action="{{ url('/logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ url('/login') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-4 py-2 text-sm font-medium">
                        Entrar
                    </a>
                    <a href="{{ url('/register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        Cadastrar
                    </a>
                @endauth

                <!-- Mobile menu button -->
                <button class="md:hidden text-gray-700 dark:text-gray-300" @click="mobileMenuOpen = !mobileMenuOpen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" x-cloak class="md:hidden border-t border-gray-200 dark:border-gray-700">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}" class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                Início
            </a>
            @auth
                <a href="{{ url('/dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    Dashboard
                </a>
            @endauth
        </div>
    </div>
</header>
