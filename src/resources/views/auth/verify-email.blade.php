@extends('layouts.app')

@section('title', 'Verifique seu Email')

@section('content')
<div class="min-h-[80vh] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 dark:bg-gray-900">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Obrigado por se inscrever! Antes de começar, você poderia verificar seu endereço de email clicando no link que acabamos de enviar para você? Se você não recebeu o email, teremos prazer em enviar outro.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ __('Um novo link de verificação foi enviado para o endereço de email fornecido durante o registro.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf

                <div>
                    <x-button type="submit" variant="primary">
                        {{ __('Reenviar Email de Verificação') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Sair') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
