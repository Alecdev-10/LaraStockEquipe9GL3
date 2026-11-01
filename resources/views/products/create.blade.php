<x-app-layout>
    <x-slot name="header"><h1 class="page-title">Ajouter un produit</h1></x-slot>
    <div class="page-container max-w-3xl">
        <section class="panel">
            <form method="POST" action="{{ route('products.store') }}">
                @csrf
                @include('products.form', ['buttonText' => 'Ajouter le produit'])
            </form>
        </section>
    </div>
</x-app-layout>
