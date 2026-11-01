<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">Mon profil</h1>
    </x-slot>

    <div class="page-container max-w-3xl space-y-6">
        <section class="panel">
            @include('profile.partials.update-profile-information-form')
        </section>

        <section class="panel">
            @include('profile.partials.update-password-form')
        </section>

        <section class="panel border-red-200">
            @include('profile.partials.delete-user-form')
        </section>
    </div>
</x-app-layout>
