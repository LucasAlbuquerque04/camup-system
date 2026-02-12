@extends('layouts.guest')

@section('title', 'Email Verificado')

@section('content')
<div class="text-center">
    <!-- Success Icon with Animation -->
    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 dark:bg-green-900 mb-6 animate-bounce">
        <svg class="h-12 w-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>

    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">
        Email Verificado!
    </h2>

    <p class="text-base text-gray-600 dark:text-gray-400 mb-2">
        Parabéns! Seu endereço de email foi verificado com sucesso.
    </p>

    <p class="text-sm text-gray-500 dark:text-gray-500 mb-8">
        Agora você tem acesso completo a todas as funcionalidades do CamUp.
    </p>

    <!-- Verified Email Display -->
    <div class="mb-8 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
        <div class="flex items-center justify-center">
            <svg class="h-5 w-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-sm font-medium text-green-800 dark:text-green-300">
                {{ auth()->user()->email }}
            </p>
        </div>
    </div>

    <!-- Call to Action -->
    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-8 py-3 text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        Ir para o Dashboard
    </a>

    <p class="mt-6 text-xs text-gray-500 dark:text-gray-500">
        Você será redirecionado automaticamente em <span id="countdown">5</span> segundos...
    </p>
</div>

<script>
    // Auto-redirect countdown
    let seconds = 5;
    const countdownElement = document.getElementById('countdown');
    
    const countdown = setInterval(function() {
        seconds--;
        countdownElement.textContent = seconds;
        
        if (seconds <= 0) {
            clearInterval(countdown);
            window.location.href = "{{ route('dashboard') }}";
        }
    }, 1000);
</script>
@endsection
