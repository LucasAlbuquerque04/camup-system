<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CamUp') }} - @yield('title', 'Sistema de Gestão')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased">
    <div class="min-h-screen flex flex-col">
        @include('components.header')

        <div class="flex-1 flex">
            @hasSection('sidebar')
                @include('components.sidebar')
            @endif

            <main class="flex-1 p-6 lg:p-8">
                @if(session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showSuccess('{{ session('success') }}');
                        });
                    </script>
                @endif

                @if(session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showError('{{ session('error') }}');
                        });
                    </script>
                @endif

                @yield('content')
            </main>
        </div>

        @include('components.footer')
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Helper para detectar tema
    const isDarkMode = () => document.documentElement.classList.contains('dark');

    // Cores do tema
    const getThemeColors = () => ({
        background: isDarkMode() ? '#1F2937' : '#FFFFFF',
        color: isDarkMode() ? '#F3F4F6' : '#111827'
    });

    // Configuração base do Toast
    const getToastMixin = () => Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        ...getThemeColors(),
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    // Inicializa o Toast globalmente
    window.Toast = getToastMixin();

    window.showSuccess = (message, title = 'Sucesso!') => {
        getToastMixin().fire({
            icon: 'success',
            title: title,
            text: message
        });
    };

    window.showError = (message, title = 'Erro!') => {
        getToastMixin().fire({
            icon: 'error',
            title: title,
            text: message
        });
    };

    window.confirmDelete = (callback, title = 'Tem certeza?', text = 'Esta ação não poderá ser revertida!', confirmText = 'Sim, excluir!') => {
        Swal.fire({
            title: title,
            html: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: confirmText,
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            ...getThemeColors()
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    };

    // Observador para mudança de tema em tempo real
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === 'class') {
                window.Toast = getToastMixin();
            }
        });
    });

    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });
</script>

    @stack('scripts')
</body>
</html>
