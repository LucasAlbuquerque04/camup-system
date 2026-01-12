@extends('layouts.app')

@section('title', 'Importação Bancária')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <x-card title="Importar Extrato">
        <div class="text-center py-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                <svg class="w-8 h-8 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Importação de OFX/CSV</h3>
            <p class="mt-2 text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
                Em breve você poderá importar seu extrato bancário diretamente para o sistema.
            </p>
            <div class="mt-6">
                <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="max-w-xs mx-auto">
                        <x-button type="button" class="w-full opacity-50 cursor-not-allowed">
                            Selecionar Arquivo
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </x-card>
@endsection
