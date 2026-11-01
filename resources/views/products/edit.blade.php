<x-app-layout>
    <x-slot name="header"><h1 class="page-title">Modifier le produit</h1></x-slot>
    <div class="page-container max-w-3xl">
        <section class="panel">
            <form method="POST" action="{{ route('products.update', $product) }}">
                @csrf
                @method('PUT')
                @include('products.form', ['buttonText' => 'Enregistrer les changements'])
            </form>
        </section>
    </div>
</x-app-layout>
