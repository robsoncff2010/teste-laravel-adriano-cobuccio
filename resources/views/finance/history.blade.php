<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.history') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-7xl">
                    <section>
                        @if(session('success'))
                            <div class="text-green-600 font-semibold mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="text-red-600 font-semibold mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="text-red-600 font-semibold mb-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('messages.history') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('messages.history_description') }}
                            </p>
                        </header>
                        <div class="mt-6">
                            <div x-data="transactionTable()" class="bg-white dark:bg-gray-800">
                                {{-- Barra de busca e limite por página --}}
                                <div class="mb-4 flex justify-between items-center">
                                    <input type="text" x-model="search" placeholder="{{ __('messages.search_placeholder') }}"
                                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded px-3 py-2 w-1/3 text-sm">
                                    <select x-model="perPage"
                                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded px-2 py-1 text-sm">
                                        <option value="5">{{ __('messages.per_page_5') }}</option>
                                        <option value="10">{{ __('messages.per_page_10') }}</option>
                                        <option value="25">{{ __('messages.per_page_25') }}</option>
                                    </select>
                                </div>

                                {{-- Tabela --}}
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th @click="sortBy('date')" class="px-4 py-2 cursor-pointer text-left font-medium text-gray-500 dark:text-gray-300">{{ __('messages.date') }}</th>
                                                <th @click="sortBy('type')" class="px-4 py-2 cursor-pointer text-left font-medium text-gray-500 dark:text-gray-300">{{ __('messages.type') }}</th>
                                                <th @click="sortBy('amount')" class="px-4 py-2 cursor-pointer text-left font-medium text-gray-500 dark:text-gray-300">{{ __('messages.amount') }}</th>
                                                <th @click="sortBy('sender')" class="px-4 py-2 cursor-pointer text-left font-medium text-gray-500 dark:text-gray-300">{{ __('messages.sender') }}</th>
                                                <th @click="sortBy('receiver')" class="px-4 py-2 cursor-pointer text-left font-medium text-gray-500 dark:text-gray-300">{{ __('messages.receiver') }}</th>
                                                <th @click="sortBy('status')" class="px-4 py-2 cursor-pointer text-left font-medium text-gray-500 dark:text-gray-300">{{ __('messages.status') }}</th>
                                                <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300">{{ __('messages.actions') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            <template x-for="transaction in paginatedTransactions()" :key="transaction.id">
                                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200 text-sm" x-text="transaction.date"></td>
                                                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200 text-sm"
                                                        x-text="{'deposit':'Depósito','transfer':'Transferência'}[transaction.type]"></td>
                                                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200 text-sm" x-text="transaction.amount"></td>
                                                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200 text-sm" x-text="transaction.sender"></td>
                                                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200 text-sm" x-text="transaction.receiver"></td>
                                                    <td class="px-4 py-2 text-sm">
                                                        <span class="font-semibold"
                                                            :class="{
                                                                'text-green-600': transaction.status === 'completed',
                                                                'text-red-600': transaction.status === 'reversed',
                                                                'text-yellow-600': transaction.status === 'reversal_requested'
                                                            }"
                                                            x-text="{
                                                                'completed':'Concluída',
                                                                'reversed':'Revertida',
                                                                'reversal_requested':'Reversão solicitada'
                                                            }[transaction.status]">
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200 text-sm">
                                                        <!-- Depósito -->
                                                        <template x-if="transaction.type === 'deposit'">
                                                            <div>
                                                                <template x-if="transaction.status === 'completed'">
                                                                    <button 
                                                                        @click="$dispatch('open-modal', 'confirm-revert-'+transaction.id)"
                                                                        class="w-full text-center bg-red-600 hover:bg-red-700 text-white rounded px-3 py-1 text-sm">
                                                                        {{ __('messages.revert') }}
                                                                    </button>
                                                                </template>
                                                                <template x-if="transaction.status === 'reversed'">
                                                                    <button class="w-full text-center bg-yellow-500 text-white rounded px-3 py-1 line-through cursor-not-allowed text-sm" disabled>
                                                                        {{ __('messages.revert') }}
                                                                    </button>
                                                                </template>
                                                            </div>
                                                        </template>

                                                        <!-- Transferência -->
                                                        <template x-if="transaction.type === 'transfer'">
                                                            <div>
                                                                <template x-if="transaction.status === 'completed'">
                                                                    <button 
                                                                        @click="$dispatch('open-modal', 'confirm-request-'+transaction.id)"
                                                                        class="w-full text-center bg-blue-600 hover:bg-blue-700 text-white rounded px-3 py-1 text-sm">
                                                                        {{ __('messages.request_reversal') }}
                                                                    </button>
                                                                </template>
                                                                <template x-if="transaction.status === 'reversal_requested'">
                                                                    <button class="w-full text-center bg-yellow-500 text-white rounded px-3 py-1 line-through cursor-not-allowed text-sm" disabled>
                                                                        {{ __('messages.request_reversal') }}
                                                                    </button>
                                                                </template>
                                                            </div>
                                                        </template>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>

                                        <tfoot class="bg-gray-100 dark:bg-gray-700">
                                            <tr>
                                                <td colspan="3" class="px-4 py-2 text-gray-700 dark:text-gray-200 font-semibold text-sm">{{ __('messages.total_page') }}</td>
                                                <td class="px-4 py-2 text-gray-700 dark:text-gray-200 font-semibold text-sm" x-text="totalAmountPage()"></td>
                                                <td colspan="3"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                {{-- Paginação --}}
                                <div class="mt-4 flex justify-between items-center text-sm">
                                    <button @click="prevPage" :disabled="page === 1"
                                        class="px-3 py-1 bg-gray-300 dark:bg-gray-700 rounded disabled:opacity-50">{{ __('messages.previous') }}</button>
                                    <span class="text-gray-700 dark:text-gray-200">{{ __('messages.page') }} <span x-text="page"></span> {{ __('messages.of') }} <span x-text="totalPages()"></span></span>
                                    <button @click="nextPage" :disabled="page >= totalPages()"
                                        class="px-3 py-1 bg-gray-300 dark:bg-gray-700 rounded disabled:opacity-50">{{ __('messages.next') }}</button>
                                </div>
                            </div>
                        </div>

                        {{-- Modais de confirmação --}}
                        @foreach($transactions as $transaction)
                            <!-- Modal de reversão -->
                            <x-modal :name="'confirm-revert-'.$transaction['id']">
                                <div class="p-6 text-sm">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                                        {{ __('messages.confirm_revert') }}
                                    </h2>
                                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                                        {{ __('messages.confirm_revert_description') }}
                                    </p>

                                    <div class="flex justify-end space-x-3">
                                        <x-danger-button @click="$dispatch('close-modal', 'confirm-revert-{{ $transaction['id'] }}')">
                                            {{ __('messages.cancel') }}
                                        </x-danger-button>
                                        <form action="{{ route('finance.history.revert', $transaction['id']) }}" method="POST">
                                            @csrf
                                            <x-primary-button type="submit">
                                                {{ __('messages.confirm') }}
                                            </x-primary-button>
                                        </form>
                                    </div>
                                </div>
                            </x-modal>

                            <!-- Modal de solicitação de reversão -->
                            <x-modal :name="'confirm-request-'.$transaction['id']">
                                <div class="p-6 text-sm">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                                        {{ __('messages.confirm_request_reversal') }}
                                    </h2>
                                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                                        {{ __('messages.confirm_request_reversal_description') }}
                                    </p>

                                    <div class="flex justify-end space-x-3">
                                        <x-danger-button @click="$dispatch('close-modal', 'confirm-request-{{ $transaction['id'] }}')">
                                            {{ __('messages.cancel') }}
                                        </x-danger-button>
                                        <form action="{{ route('finance.history.requestReversal', $transaction['id']) }}" method="POST">
                                            @csrf
                                            <x-primary-button
                                             type="submit"
                                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                                {{ __('messages.confirm') }}
                                            </x-primary-button>
                                        </form>
                                    </div>
                                </div>
                            </x-modal>
                        @endforeach
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
function transactionTable() {
    return {
        search: '',
        perPage: 10,
        page: 1,
        sortField: 'date',
        sortDirection: 'desc',
        transactions: @json($transactions), // dados vindos do backend

        get filteredTransactions() {
            let data = this.transactions;
            if (this.search) {
                data = data.filter(t =>
                    Object.values(t).some(val => String(val).toLowerCase().includes(this.search.toLowerCase()))
                );
            }
            // Ordenação
            data = data.sort((a, b) => {
                let fieldA = a[this.sortField];
                let fieldB = b[this.sortField];
                if (typeof fieldA === 'string') fieldA = fieldA.toLowerCase();
                if (typeof fieldB === 'string') fieldB = fieldB.toLowerCase();
                if (fieldA < fieldB) return this.sortDirection === 'asc' ? -1 : 1;
                if (fieldA > fieldB) return this.sortDirection === 'asc' ? 1 : -1;
                return 0;
            });
            return data;
        },
        paginatedTransactions() {
            let start = (this.page - 1) * this.perPage;
            return this.filteredTransactions.slice(start, start + this.perPage);
        },
        totalPages() {
            return Math.ceil(this.filteredTransactions.length / this.perPage);
        },
        nextPage() { if (this.page < this.totalPages()) this.page++; },
        prevPage() { if (this.page > 1) this.page--; },
        sortBy(field) {
            if (this.sortField === field) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortField = field;
                this.sortDirection = 'asc';
            }
        },
        // Total apenas dos registros exibidos na página atual
        totalAmountPage() {
            let total = this.paginatedTransactions()
                .reduce((sum, t) => {
                    // Remove pontos de milhar e troca vírgula por ponto
                    let valor = t.amount.replace(/\./g, '').replace(',', '.');
                    return sum + parseFloat(valor);
                }, 0);

            return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total);
        }

    }
}
</script>
