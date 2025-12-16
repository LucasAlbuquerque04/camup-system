@extends('layouts.guest')

@section('title', 'Recuperar Senha')

@section('content')
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Recuperar senha</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Digite seu email para receber instruções de recuperação de senha
        </p>
    </div>

    @if(session('status'))
        <x-alert type="success" class="mb-4">
            {{ session('status') }}
        </x-alert>
    @endif

    <form method="POST" action="{{ url('/forgot-password') }}">
        @csrf

        <x-input 
            label="Email"
            name="email"
            type="email"
            placeholder="seu@email.com"
            :required="true"
            autofocus
        />

        <x-button type="submit" class="w-full mb-4">
            Enviar link de recuperação
        </x-button>

        <div class="text-center">
            <a href="{{ url('/login') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                Voltar para login
            </a>
        </div>
    </form>
@endsection
