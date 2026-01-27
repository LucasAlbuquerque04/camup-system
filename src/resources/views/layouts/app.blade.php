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
    // Configuração global
    window.Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    // Helpers
    window.showSuccess = (message, title = 'Sucesso!') => {
        Toast.fire({ icon: 'success', title: title, text: message });
    };
    window.showError = (message, title = 'Erro!') => {
        Toast.fire({ icon: 'error', title: title, text: message });
    };
</script>

    @stack('scripts')
</body>
</html>
