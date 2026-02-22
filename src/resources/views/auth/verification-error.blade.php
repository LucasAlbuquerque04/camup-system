@extends('layouts.guest')

@section('title', 'Link Inválido ou Expirado')

@section('content')
<div class="text-center">
    <!-- Error Icon -->
    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 dark:bg-red-900 mb-6">
        <svg class="h-12 w-12 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>

    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">
        Link Inválido ou Expirado
    </h2>

    <p class="text-base text-gray-600 dark:text-gray-400 mb-2">
        {{ $verificationErrorMessage ?? 'Link expirado ou inválido. Solicite um novo email de verificação.' }}
    </p>

    <p class="text-sm text-gray-500 dark:text-gray-500 mb-8">
        Links de verificação são válidos por apenas 24 horas por motivos de segurança.
    </p>

    <!-- Info Box -->
    <div class="mb-8 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg text-left">
        <h3 class="text-sm font-semibold text-yellow-800 dark:text-yellow-300 mb-2">
            O que fazer agora?
        </h3>
        <ul class="text-sm text-yellow-700 dark:text-yellow-400 space-y-1 list-disc list-inside">
            <li>Clique no botão abaixo para receber um novo link de verificação</li>
            <li>Verifique sua caixa de entrada e spam</li>
            <li>O novo link será válido por 24 horas</li>
        </ul>
    </div>

    @auth
        <!-- Resend Form for Authenticated Users -->
        <form method="POST" action="{{ route('verification.resend') }}" id="resendForm" class="mb-6">
            @csrf
            <x-button type="submit" variant="primary" size="lg" class="w-full" id="resendButton">
                <svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Enviar Novo Link de Verificação
            </x-button>
        </form>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            Enviaremos um novo link para: <strong>{{ auth()->user()->email }}</strong>
        </p>

        <!-- Logout Link -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline transition">
                Sair da Conta
            </button>
        </form>
    @else
        <!-- Login Link for Guests -->
        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3 text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Fazer Login
        </a>

        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            Faça login para solicitar um novo link de verificação
        </p>
    @endauth
</div>

@auth
<script>
    // Prevent multiple rapid clicks on resend button
    document.getElementById('resendForm').addEventListener('submit', function(e) {
        const button = document.getElementById('resendButton');
        button.disabled = true;
        button.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Enviando...';
        
        // Re-enable after 3 seconds
        setTimeout(function() {
            button.disabled = false;
            button.innerHTML = '<svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>Enviar Novo Link de Verificação';
        }, 3000);
    });
</script>
@endauth
@endsection
