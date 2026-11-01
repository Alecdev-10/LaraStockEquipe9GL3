<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Adresse e-mail" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Mot de passe" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-slate-600">Se souvenir de moi</span>
            </label>
        </div>

        <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
                <a class="text-sm font-medium text-indigo-600 underline-offset-2 transition hover:text-indigo-800 hover:underline" href="{{ route('register') }}">
                    Créer un compte
                </a>
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-slate-600 underline-offset-2 transition hover:text-indigo-700 hover:underline" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            <x-primary-button>
                Se connecter
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
