@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Entrar na sua conta</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Ou
            <a href="{{ url('/register') }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                crie uma nova conta
            </a>
        </p>
    </div>

    @if(session('status'))
        <x-alert type="success" class="mb-4">
            {{ session('status') }}
        </x-alert>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf

        <x-input 
            label="Email"
            name="email"
            type="email"
            placeholder="seu@email.com"
            :required="true"
            autofocus
        />

        <x-input 
            label="Senha"
            name="password"
            type="password"
            placeholder="••••••••"
            :required="true"
        />

        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Lembrar de mim</span>
            </label>

            <a href="{{ url('/forgot-password') }}" class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                Esqueceu a senha?
            </a>
        </div>

        <x-button type="submit" class="w-full">
            Entrar
        </x-button>
    </form>
@endsection
