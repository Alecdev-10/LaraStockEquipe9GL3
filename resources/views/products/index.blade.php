<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="page-title">Produits</h1>
            <a href="{{ route('products.create') }}" class="button-primary">Ajouter un produit</a>
        </div>
    </x-slot>

    <div class="page-container">
        @if (session('success'))
            <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
        @endif

        <section class="panel mb-6">
            <form method="GET" action="{{ route('products.index') }}" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <label for="search" class="form-label">Rechercher</label>
                    <input id="search" name="search" value="{{ $search }}" placeholder="Nom ou référence" class="form-input">
                </div>
                <div>
                    <label for="category_id" class="form-label">Catégorie</label>
                    <select id="category_id" name="category_id" class="form-input">
                        <option value="">Toutes</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="form-label">État du stock</label>
                    <select id="status" name="status" class="form-input">
                        <option value="">Tous</option>
                        <option value="low" @selected(request('status') === 'low')>Stock faible</option>
                        <option value="out" @selected(request('status') === 'out')>Rupture</option>
                    </select>
                </div>
                <div>
                    <label for="sort" class="form-label">Trier par</label>
                    <select id="sort" name="sort" class="form-input">
                        <option value="name" @selected($sort === 'name')>Nom</option>
                        <option value="price" @selected($sort === 'price')>Prix</option>
                        <option value="quantity" @selected($sort === 'quantity')>Quantité</option>
                    </select>
                    <select name="direction" aria-label="Ordre de tri" class="form-input mt-2">
                        <option value="asc" @selected($direction === 'asc')>Croissant</option>
                        <option value="desc" @selected($direction === 'desc')>Décroissant</option>
                    </select>
                </div>
                <div class="flex items-end gap-2 sm:col-span-2 lg:col-span-5">
                    <button class="button-primary">Appliquer</button>
                    <a href="{{ route('products.index') }}" class="button-secondary">Effacer</a>
                </div>
            </form>
        </section>

        <section class="panel">
            @if ($products->isEmpty())
                <div class="py-10 text-center">
                    <h2 class="text-lg font-semibold text-slate-800">Aucun produit trouvé</h2>
                    <p class="mt-1 text-sm text-slate-600">Ajoutez un produit ou modifiez les critères de recherche.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-[760px] w-full text-left text-sm">
                        <thead class="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500">
                            <tr><th class="table-cell">Produit</th><th class="table-cell">Catégorie</th><th class="table-cell">Quantité</th><th class="table-cell">Prix</th><th class="table-cell">État</th><th class="table-cell">Actions</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($products as $product)
                                <tr>
                                    <td class="table-cell"><a href="{{ route('products.show', $product) }}" class="font-semibold text-indigo-700 hover:underline">{{ $product->name }}</a><span class="mt-1 block text-xs text-slate-500">{{ $product->sku ?: 'Sans référence' }}</span></td>
                                    <td class="table-cell">{{ $product->category->name }}</td>
                                    <td class="table-cell">{{ $product->quantity }}</td>
                                    <td class="table-cell">{{ number_format((float) $product->price, 2, ',', ' ') }}</td>
                                    <td class="table-cell">
                                        @if ($product->isOutOfStock()) <span class="badge-out">Rupture</span>
                                        @elseif ($product->isLowStock()) <span class="badge-low">Stock faible</span>
                                        @else <span class="badge-ok">Disponible</span> @endif
                                    </td>
                                    <td class="table-cell">
                                        <div class="flex flex-wrap gap-3">
                                            <a href="{{ route('products.edit', $product) }}" class="text-indigo-700 hover:underline">Modifier</a>
                                            <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Supprimer ce produit ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-700 hover:underline">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">{{ $products->links('pagination.products') }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
