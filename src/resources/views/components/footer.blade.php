<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                &copy; {{ date('Y') }} <span class="font-semibold">CamUp</span>. Todos os direitos reservados.
            </div>
            
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="{{ url('/sobre') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                    Sobre
                </a>
                <a href="{{ url('/suporte') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                    Suporte
                </a>
                <a href="{{ url('/termos') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                    Termos
                </a>
                <a href="{{ url('/privacidade') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                    Privacidade
                </a>
            </div>
        </div>
    </div>
</footer>
