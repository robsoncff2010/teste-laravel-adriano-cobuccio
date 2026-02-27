<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($errors->any())
        <div class="mb-4">
            <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('messages.email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('messages.password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 gap-4">
            <x-primary-button class="ms-3">
                {{ __('messages.login') }}
            </x-primary-button>
            <x-danger-button onclick="window.location.href='/register'" class="px-4 py-2">
                {{ __('messages.register') }}
            </x-danger-button>
        </div>
    </form>
</x-guest-layout>