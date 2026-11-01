<x-app-layout>
    <x-slot:header>
        <h2 class="page-title">Tableau de bord</h2>
    </x-slot:header>

    <div class="page-container">
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="panel border-l-4 border-l-indigo-500">
                <p class="text-sm font-medium text-slate-500">Produits</p>
                <p class="mt-1 text-3xl font-bold text-slate-900">{{ $productsCount }}</p>
            </div>
            <div class="panel border-l-4 border-l-emerald-500">
                <p class="text-sm font-medium text-slate-500">Valeur du stock</p>
                <p class="mt-1 text-3xl font-bold text-slate-900">{{ number_format($stockValue, 2, ',', ' ') }} €</p>
            </div>
            <div class="panel border-l-4 border-l-amber-400">
                <p class="text-sm font-medium text-slate-500">Stock faible</p>
                <p class="mt-1 text-3xl font-bold"><span class="badge-low">{{ $lowStockCount }}</span></p>
            </div>
            <div class="panel border-l-4 border-l-red-500">
                <p class="text-sm font-medium text-slate-500">Ruptures de stock</p>
                <p class="mt-1 text-3xl font-bold"><span class="badge-out">{{ $outOfStockCount }}</span></p>
            </div>
        </div>

        <div class="mb-6 flex flex-wrap gap-3">
            <a href="{{ route('products.index') }}" class="button-primary">Voir les produits</a>
            <a href="{{ route('categories.index') }}" class="button-secondary">Gérer les catégories</a>
        </div>

        <div class="panel mb-6">
            <h3 class="mb-3 text-lg font-semibold text-slate-900">Alertes de stock</h3>
            @if ($alerts->isEmpty())
                <p class="text-slate-500">Aucune alerte : tous les stocks sont au-dessus de leur seuil.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="table-cell">Produit</th>
                                <th class="table-cell">Référence</th>
                                <th class="table-cell">Catégorie</th>
                                <th class="table-cell">Stock</th>
                                <th class="table-cell">Seuil</th>
                                <th class="table-cell text-right">Prix</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($alerts as $product)
                                <tr>
                                    <td class="table-cell">
                                        <a href="{{ route('products.show', $product) }}" class="font-semibold text-indigo-700 hover:underline">{{ $product->name }}</a>
                                    </td>
                                    <td class="table-cell">{{ $product->sku }}</td>
                                    <td class="table-cell">{{ $product->category->name }}</td>
                                    <td class="table-cell">
                                        @if ($product->isOutOfStock())
                                            <span class="badge-out">{{ $product->quantity }}</span>
                                        @else
                                            <span class="badge-low">{{ $product->quantity }}</span>
                                        @endif
                                    </td>
                                    <td class="table-cell">{{ $product->low_stock_threshold }}</td>
                                    <td class="table-cell text-right">{{ number_format((float) $product->price, 2, ',', ' ') }} €</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="panel">
            <h3 class="mb-3 text-lg font-semibold text-slate-900">Répartition par catégorie</h3>
            @if ($perCategory->isEmpty())
                <p class="text-slate-500">Aucune catégorie enregistrée.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="table-cell">Catégorie</th>
                                <th class="table-cell">Produits</th>
                                <th class="table-cell">Quantité totale</th>
                                <th class="table-cell text-right">Valeur</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($perCategory as $row)
                                <tr>
                                    <td class="table-cell font-medium">{{ $row['name'] }}</td>
                                    <td class="table-cell">{{ $row['count'] }}</td>
                                    <td class="table-cell">{{ $row['quantity'] }}</td>
                                    <td class="table-cell text-right">{{ number_format($row['value'], 2, ',', ' ') }} €</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
