<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.portfolio') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Main cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <h3 class="text-sm text-gray-500 dark:text-gray-300">{{ __('messages.current_balance') }}</h3>
                    <p class="text-2xl font-bold text-green-600">
                        $ {{ number_format($balance, 2, ',', '.') }}
                    </p>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <h3 class="text-sm text-gray-500 dark:text-gray-300">{{ __('messages.entries') }}</h3>
                    <p class="text-2xl font-bold text-blue-600">
                        $ {{ number_format($incomes, 2, ',', '.') }}
                    </p>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <h3 class="text-sm text-gray-500 dark:text-gray-300">{{ __('messages.exits') }}</h3>
                    <p class="text-2xl font-bold text-red-600">
                        $ {{ number_format($expenses, 2, ',', '.') }}
                    </p>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <h3 class="text-sm text-gray-500 dark:text-gray-300">{{ __('messages.transactions') }}</h3>
                    <p class="text-2xl font-bold text-yellow-600">
                        {{ $totalTransactions }}
                    </p>
                </div>
            </div>

            {{-- Charts side by side --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                        {{ __('messages.wallet_distribution') }}
                    </h3>
                    <canvas id="walletDonut"></canvas>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                        {{ __('messages.wallet_evolution') }}
                    </h3>
                    <canvas id="walletLine"></canvas>
                </div>
            </div>

            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                    {{ __('messages.last_transactions') }}
                </h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('messages.date') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('messages.type') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('messages.amount') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('messages.sender') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('messages.receiver') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('messages.status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($latestTransactions as $t)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $t['date'] }}</td>
                                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ ucfirst($t['type']) }}</td>
                                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $t['amount'] }}</td>
                                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $t['sender'] }}</td>
                                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $t['receiver'] }}</td>
                                    <td class="px-4 py-2 font-semibold
                                        @if($t['status'] === 'completed') text-green-600
                                        @elseif($t['status'] === 'reversed') text-red-600
                                        @elseif($t['status'] === 'reversal_requested') text-yellow-600
                                        @endif">
                                        {{ ucfirst($t['status']) }}
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-right">
                    <a href="{{ route('finance.history.index') }}" 
                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 font-semibold">
                        {{ __('messages.last_transactions') }} →
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Donut
    new Chart(document.getElementById('walletDonut'), {
        type: 'doughnut',
        data: {
            labels: ['{{ __('messages.deposit') }}', '{{ __('messages.transfer') }}'],
            datasets: [{
                data: [@json($chartDepositsTotal), @json($chartTransfersTotal)],
                backgroundColor: ['#16a34a', '#2563eb']
            }]
        }
    });
    
    // Line
    new Chart(document.getElementById('walletLine'), {
        type: 'line',
        data: {
            labels: ['01', '05', '10', '15', '20', '25'], // replace with real labels
            datasets: [{
                label: '{{ __('messages.balance_evolution') }}',
                data: [1000, 2000, 2500, 3000, 2800, 3500], // replace with real data
                borderColor: '#16a34a',
                fill: true,
                backgroundColor: 'rgba(22,163,74,0.2)'
            }]
        }
    });
</script>