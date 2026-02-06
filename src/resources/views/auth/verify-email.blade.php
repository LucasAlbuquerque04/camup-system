@extends('layouts.guest')

@section('title', 'Verificar Email')

@section('content')
<div class="text-center">
    <!-- Envelope Icon -->
    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900 mb-6">
        <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
    </div>

    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
        Verifique seu Email
    </h2>

    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
        Enviamos um link de verificação para:
    </p>

    <p class="text-base font-semibold text-gray-900 dark:text-white mb-6 px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg inline-block">
        {{ auth()->user()->email }}
    </p>

    <p class="text-sm text-gray-600 dark:text-gray-400 mb-8">
        Por favor, clique no link enviado para o seu email para verificar sua conta e começar a usar o CamUp.
    </p>

    <!-- Success Message -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm font-medium text-green-800 dark:text-green-300">
                    Um novo link de verificação foi enviado para seu email!
                </p>
            </div>
        </div>
    @endif

    <!-- Error Message -->
    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-600 dark:text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm font-medium text-red-800 dark:text-red-300">
                    {{ session('error') }}
                </p>
            </div>
        </div>
    @endif

    <!-- Resend Form -->
    <form method="POST" action="{{ route('verification.resend') }}" id="resendForm">
        @csrf
        <x-button type="submit" variant="primary" size="lg" class="w-full mb-4" id="resendButton">
            <svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Reenviar Email de Verificação
        </x-button>
    </form>

    <!-- Logout Link -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline transition">
            Sair da Conta
        </button>
    </form>
</div>

<script>
    // Prevent multiple rapid clicks on resend button
    document.getElementById('resendForm').addEventListener('submit', function(e) {
        const button = document.getElementById('resendButton');
        button.disabled = true;
        button.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Enviando...';
        
        // Re-enable after 3 seconds
        setTimeout(function() {
            button.disabled = false;
            button.innerHTML = '<svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Reenviar Email de Verificação';
        }, 3000);
    });
</script>
@endsection
