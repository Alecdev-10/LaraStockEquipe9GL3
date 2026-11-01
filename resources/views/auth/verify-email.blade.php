<x-guest-layout>
    <div class="mb-4 text-sm text-slate-600">
        Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer. Si vous n'avez pas reçu l'e-mail, nous vous en enverrons un nouveau avec plaisir.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm font-medium text-green-700">
            Un nouveau lien de vérification a été envoyé à l'adresse e-mail indiquée lors de l'inscription.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    Renvoyer l'e-mail de vérification
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-sm text-slate-600 underline-offset-2 transition hover:text-indigo-700 hover:underline">
                Se déconnecter
            </button>
        </form>
    </div>
</x-guest-layout>
