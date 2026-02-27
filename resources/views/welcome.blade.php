<x-guest-layout>
    <div class="w-full mx-auto mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg text-center">
        <x-input-label>
            Teste - Projeto Adriano Cobuccio
        </x-input-label>
    </div>
    <div class="mt-6">
        <nav class="flex items-center justify-end gap-4">
            <x-primary-button 
                onclick="window.location.href='/login'" 
                class="px-4 py-2">
                {{ __('messages.login') }}
            </x-primary-button >

            <x-danger-button  
                onclick="window.location.href='/register'" 
                class="px-4 py-2">
                {{ __('messages.register') }}
            </x-danger-button >
        </nav>
    </div>
</x-guest-layout>

