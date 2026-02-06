@extends('layouts.app')

@section('title', 'Transações')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
<div class="max-w-7xl mx-auto" x-data="transactionHandler()" x-cloak>
    
    <!-- Inline Style for x-cloak (Safety) -->
    <style>[x-cloak] { display: none !important; }</style>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gerenciar Transações</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Mantenha seu controle financeiro atualizado</p>
        </div>
        <button 
            type="button" 
            @click="openCreate()"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nova Transação
        </button>
    </div>

    <!-- Filters -->
    <x-card class="mb-6">
        <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Type Filter -->
            <div>
                <label for="filter_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo</label>
                <select 
                    id="filter_type" 
                    name="type" 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
                    <option value="">Todos</option>
                    <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Receita</option>
                    <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Despesa</option>
                </select>
            </div>

            <!-- Date Range From -->
            <div>
                <label for="filter_date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">De</label>
                <input 
                    type="date" 
                    id="filter_date_from" 
                    name="date_from" 
                    value="{{ request('date_from') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
            </div>

            <!-- Date Range To -->
            <div>
                <label for="filter_date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Até</label>
                <input 
                    type="date" 
                    id="filter_date_to" 
                    name="date_to" 
                    value="{{ request('date_to') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
            </div>

            <!-- Filter Actions -->
            <div class="flex items-end gap-2">
                <x-button type="submit" variant="primary" class="flex-1">Filtrar</x-button>
                <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white rounded-lg transition">Limpar</a>
            </div>
        </form>
    </x-card>

    <!-- Transactions Table -->
    <x-card title="Minhas Transações">
        @if($transactions->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Nenhuma transação encontrada.</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comece registrando sua primeira transação.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white">Descrição</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white">Categoria</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white">Data</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white text-right">Valor</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($transactions as $transaction)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <td class="px-4 py-3 text-gray-900 dark:text-white">
                                    {{ $transaction->description }}
                                </td>
                                <td class="px-4 py-3">
                                    <span 
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium"
                                        style="background-color: {{ $transaction->category->color }}20; color: {{ $transaction->category->color }}"
                                    >
                                        <span 
                                            class="w-2 h-2 rounded-full mr-1.5" 
                                            style="background-color: {{ $transaction->category->color }}"
                                        ></span>
                                        {{ $transaction->category->name }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $transaction->date->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 text-right font-semibold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-1">
                                        <!-- Edit Button (Alpine) -->
                                        <button 
                                            type="button"
                                            @click='openEdit(@json($transaction))'
                                            class="p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition"
                                            title="Editar transação"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Delete Button -->
                                        <form 
                                            method="POST" 
                                            action="{{ route('transactions.destroy', $transaction->id) }}" 
                                            class="inline delete-form"
                                            data-transaction-description="{{ $transaction->description }}"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition"
                                                title="Excluir transação"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>

    <!-- Transaction Modal (Alpine) -->
    <div 
        x-show="showModal" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
    >
        <div 
            class="w-full max-w-lg" 
            @click.outside="showModal = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <x-card>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" x-text="modalTitle">Nova Transação</h3>
                    <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="submitForm">
                    <!-- Description -->
                    <div class="mb-4">
                        <label for="input_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Descrição <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            x-model="form.description"
                            maxlength="35"
                            placeholder="Ex: Salário, Conta de luz"
                            :class="{'border-red-500': errors.description}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                        >
                        <template x-if="errors.description">
                            <p class="mt-1 text-sm text-red-600" x-text="errors.description[0]"></p>
                        </template>
                    </div>

                    <!-- Amount -->
                    <div class="mb-4">
                        <label for="input_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Valor (R$) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            x-model="form.amount"
                            @input="formatMoney($event)"
                            placeholder="0,00"
                            :class="{'border-red-500': errors.amount}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                        >
                        <template x-if="errors.amount">
                            <p class="mt-1 text-sm text-red-600" x-text="errors.amount[0]"></p>
                        </template>
                    </div>

                    <!-- Date -->
                    <div class="mb-4">
                        <label for="input_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Data <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            x-model="form.date"
                            :class="{'border-red-500': errors.date}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                        >
                         <template x-if="errors.date">
                            <p class="mt-1 text-sm text-red-600" x-text="errors.date[0]"></p>
                        </template>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="input_category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Categoria <span class="text-red-500">*</span>
                        </label>
                        <select 
                            x-model="form.category_id"
                            :class="{'border-red-500': errors.category_id}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                        >
                            <option value="">Selecione uma categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }} ({{ $category->type === 'income' ? 'Receita' : 'Despesa' }})
                                </option>
                            @endforeach
                        </select>
                         <template x-if="errors.category_id">
                            <p class="mt-1 text-sm text-red-600" x-text="errors.category_id[0]"></p>
                        </template>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 mt-6">
                        <x-button type="button" variant="secondary" @click="showModal = false" x-bind:disabled="isSubmitting">
                            Cancelar
                        </x-button>
                        <x-button type="submit" variant="primary" x-bind:disabled="isSubmitting">
                            <span x-show="isSubmitting">Salvando...</span>
                            <span x-show="!isSubmitting">Salvar</span>
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('transactionHandler', () => ({
            showModal: false,
            isSubmitting: false,
            modalTitle: 'Nova Transação',
            config: {
                action: '{{ route("transactions.store") }}',
                method: 'POST'
            },
            form: {
                description: '',
                amount: '',
                date: new Date().toISOString().split('T')[0],
                category_id: ''
            },
            errors: {},

            formatMoney(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (!value) {
                    this.form.amount = '';
                    return;
                }
                value = (parseFloat(value) / 100).toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                e.target.value = value;
                this.form.amount = value;
            },

            openCreate() {
                this.modalTitle = 'Nova Transação';
                this.config.action = '{{ route("transactions.store") }}';
                this.config.method = 'POST';
                this.form.description = '';
                this.form.amount = '';
                this.form.date = new Date().toISOString().split('T')[0];
                this.form.category_id = '';
                this.errors = {};
                this.showModal = true;
            },

            openEdit(t) {
                this.modalTitle = 'Editar Transação';
                this.config.action = `/transactions/${t.id}`;
                this.config.method = 'PUT';
                
                this.form.description = t.description;
                this.form.amount = parseFloat(t.amount).toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                this.form.date = t.date.split('T')[0];
                this.form.category_id = t.category_id;
                
                this.errors = {};
                this.showModal = true;
            },

            async submitForm() {
                this.isSubmitting = true;
                this.errors = {};

                try {
                    const method = this.config.method.toUpperCase();
                    const url = this.config.action;
                    
                    let data = { ...this.form };
                    
                    // Laravel Method Spoofing: Always send POST, use _method for PUT/PATCH
                    if (method === 'PUT' || method === 'PATCH') {
                        data._method = method;
                    }

                    // Always use POST
                    const response = await axios.post(url, data);

                    // Success
                    window.location.reload();

                } catch (error) {
                    this.isSubmitting = false;
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error('AJAX Error:', error);
                        // User requested to remove the generic alert
                        // alert('Ocorreu um erro inesperado. Verifique o console.');
                    }
                }
            }
        }))
    });

    // Delete confirmation (Global helper)
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const description = this.dataset.transactionDescription;
            window.confirmDelete(
                () => this.submit(),
                'Tem certeza que deseja excluir esta transação?',
                `A transação <strong>${description}</strong> será removida permanentemente.`
            );
        });
    });
</script>
@endpush
@endsection
