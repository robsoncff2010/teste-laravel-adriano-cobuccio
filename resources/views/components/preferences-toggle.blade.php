<div class="flex space-x-6 items-center">
    <!-- Toggle de Tema -->
    <form method="POST" action="{{ route('theme.switch') }}">
        @csrf
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" name="theme" value="dark" class="sr-only"
                onchange="this.form.submit()"
                {{ session('theme') === 'dark' ? 'checked' : '' }}>
            <span class="relative w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full transition">
                <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform"
                      style="{{ session('theme') === 'dark' ? 'transform: translateX(20px);' : '' }}"></span>
            </span>
            <span class="ml-2 text-gray-800 dark:text-gray-200">
                {{ session('theme') === 'dark' ? 'Tema Escuro' : 'Tema Claro' }}
            </span>
        </label>
    </form>

    <!-- Toggle de Idioma -->
    <form method="POST" action="{{ route('language.switch') }}">
        @csrf
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" name="locale" value="en" class="sr-only"
                onchange="this.form.submit()"
                {{ app()->getLocale() === 'en' ? 'checked' : '' }}>
            <span class="relative w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full transition">
                <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform"
                    style="{{ app()->getLocale() === 'en' ? 'transform: translateX(20px);' : '' }}">
                </span>
            </span>
            <span class="ml-2 text-gray-800 dark:text-gray-200">
                {{ app()->getLocale() === 'en' ? 'English' : 'Português' }}
            </span>
        </label>
    </form>
</div>
