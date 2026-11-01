<x-app-layout>
    <x-slot name="header"><h1 class="page-title">Détail du produit</h1></x-slot>
    <div class="page-container max-w-3xl">
        <section class="panel">
            <div class="grid gap-5 sm:grid-cols-2">
                <div><p class="detail-label">Nom</p><p class="detail-value">{{ $product->name }}</p></div>
                <div><p class="detail-label">Catégorie</p><p class="detail-value">{{ $product->category->name }}</p></div>
                <div><p class="detail-label">Référence</p><p class="detail-value">{{ $product->sku ?: '—' }}</p></div>
                <div><p class="detail-label">Quantité en stock</p><p class="detail-value">{{ $product->quantity }}</p></div>
                <div><p class="detail-label">Prix unitaire</p><p class="detail-value">{{ number_format((float) $product->price, 2, ',', ' ') }}</p></div>
                <div><p class="detail-label">Seuil d’alerte</p><p class="detail-value">{{ $product->low_stock_threshold }}</p></div>
            </div>
            <div class="mt-5">
                @if ($product->isOutOfStock())
                    <span class="badge-out">Rupture de stock</span>
                @elseif ($product->isLowStock())
                    <span class="badge-low">Stock faible</span>
                @else
                    <span class="badge-ok">Stock suffisant</span>
                @endif
            </div>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('products.edit', $product) }}" class="button-primary">Modifier</a>
                <a href="{{ route('products.index') }}" class="button-secondary">Retour à la liste</a>
            </div>
        </section>
    </div>
</x-app-layout>
