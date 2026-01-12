<aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 hidden lg:block">
    <nav class="h-full overflow-y-auto py-6">
        <div class="px-4 mb-6">
            <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Principal</h2>
        </div>
        
        <ul class="space-y-1 px-2">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
        </ul>

        <div class="px-4 mt-6 mb-4">
            <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Gestão</h2>
        </div>

        <ul class="space-y-1 px-2">
            <li>
                <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition {{ request()->routeIs('transactions*') ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Transações
                </a>
            </li>

            <li>
                <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition {{ request()->routeIs('categories*') ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 font-medium' : '' }}">
                   <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Categorias
                </a>
            </li>

            <li>
                <a href="{{ route('import.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition {{ request()->routeIs('import*') ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 font-medium' : '' }}">
                   <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Importar Extrato
                </a>
            </li>
        </ul>
        
         <div class="px-4 mt-6 mb-4">
            <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sistema</h2>
        </div>
        
        <ul class="space-y-1 px-2">
             <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 rounded-lg transition cursor-pointer">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Sair
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
