@extends('layouts.guest')

@section('title', 'Cadastro')

@section('content')
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Criar nova conta</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Já tem uma conta?
            <a href="{{ url('/login') }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                Faça login
            </a>
        </p>
    </div>

    <form method="POST" action="{{ url('/register') }}">
        @csrf

        <x-input 
            label="Nome completo"
            name="name"
            type="text"
            placeholder="Seu nome"
            :required="true"
            autofocus
        />

        <x-input 
            label="Email"
            name="email"
            type="email"
            placeholder="seu@email.com"
            :required="true"
        />

        <x-input 
            label="Senha"
            name="password"
            type="password"
            placeholder="••••••••"
            :required="true"
        />

        <x-input 
            label="Confirmar senha"
            name="password_confirmation"
            type="password"
            placeholder="••••••••"
            :required="true"
        />

        <div class="mb-6">
            <label class="flex items-start">
                <input type="checkbox" name="terms" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                    Eu concordo com os
                    <a href="{{ url('/termos') }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                        termos de uso
                    </a>
                    e
                    <a href="{{ url('/privacidade') }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                        política de privacidade
                    </a>
                </span>
            </label>
        </div>

        <x-button type="submit" class="w-full">
            Criar conta
        </x-button>
    </form>
@endsection
