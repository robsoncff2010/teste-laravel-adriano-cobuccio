<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.transfer') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        @if(session('success'))
                            <div class="text-green-600 font-semibold mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('messages.transfer') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('messages.transfer_description') }}
                            </p>
                        </header>

                        <form id="transfer-form" method="POST" action="{{ route('finance.transfer.store') }}" class="mt-4">
                            @csrf

                            {{-- Seleção de usuário destinatário --}}
                            <div class="mt-4">
                                <x-input-label for="receiver_id" :value="__('Select User')" />
                                <select id="receiver_id" name="receiver_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- {{ __('messages.choose_user') }} --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Valor da transferência --}}
                            <div class="mt-4">
                                <x-input-label for="amount" :value="__('messages.amount')" />
                                <x-text-input id="amount" name="amount" type="text"  
                                    class="mt-1 block w-full text-green-600" autocomplete="amount" />
                            </div>
                            
                            <div class="flex items-center gap-4 mt-4">
                                <x-primary-button
                                    type="button"
                                    x-data=""
                                    x-on:click="$dispatch('open-modal', 'confirm-add-transfer')"
                                >
                                    {{ __('messages.add_transfer') }}
                                </x-primary-button>
                            </div>
                        </form>

                        <x-modal name="confirm-add-transfer" :show="$errors->isNotEmpty()" focusable>
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('messages.confirm_transfer') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('messages.confirm_transfer_description') }}
                                </p>

                                {{-- Exibe erros dentro do modal também --}}
                                @if ($errors->any())
                                    <div class="mt-3 text-red-600 text-sm">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="mt-6 flex justify-end">
                                    <x-danger-button type="button" x-on:click="$dispatch('close')">
                                        {{ __('messages.cancel') }}
                                    </x-danger-button>

                                    {{-- Confirmar envia o formulário principal --}}
                                    <x-primary-button class="ms-3"  
                                        x-on:click="document.getElementById('transfer-form').submit()">
                                        {{ __('messages.confirm') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </x-modal>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>