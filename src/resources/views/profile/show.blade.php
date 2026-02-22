@extends('layouts.app')

@section('title', 'Perfil')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Perfil</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Informações da sua conta e status de verificação.</p>
    </div>

    <div class="max-w-3xl space-y-6">
        <x-card title="Dados da Conta">
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status de verificação</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">
                        @if ($user->hasVerifiedEmail())
                            Email verificado em: {{ $user->email_verified_at?->format('d/m/Y H:i') }}
                        @else
                            Email não verificado
                        @endif
                    </dd>
                </div>
            </dl>
        </x-card>

        @if (! $user->hasVerifiedEmail())
            <x-card title="Verificação de Email">
                <div class="space-y-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Sua conta ainda não foi verificada. Reenvie um novo link de verificação (válido por 24h).
                    </p>

                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <x-button type="submit" variant="primary">
                            Reenviar email de verificação
                        </x-button>
                    </form>
                </div>
            </x-card>
        @endif
    </div>
@endsection
