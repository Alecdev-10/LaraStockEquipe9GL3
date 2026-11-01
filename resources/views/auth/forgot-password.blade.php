<x-guest-layout>
    <div class="mb-4 text-sm text-slate-600">
        Mot de passe oublié ? Aucun problème : indiquez votre adresse e-mail, nous vous enverrons un lien pour choisir un nouveau mot de passe.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')) />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Adresse e-mail" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6 flex items-center justify-end">
            <x-primary-button>
                Envoyer le lien de réinitialisation
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
