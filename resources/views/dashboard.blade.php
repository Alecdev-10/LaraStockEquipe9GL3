<x-app-layout>
    <x-slot:header>
        <h2 class="page-title">Tableau de bord</h2>
    </x-slot:header>

    <div class="page-container">
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="panel">
                <p class="text-sm text-gray-500">Produits</p>
                <p class="text-2xl font-semibold">{{ $productsCount }}</p>
            </div>
            <div class="panel">
                <p class="text-sm text-gray-500">Valeur du stock</p>
                <p class="text-2xl font-semibold">{{ number_format($stockValue, 2, ',', ' ') }} €</p>
            </div>
            <div class="panel">
                <p class="text-sm text-gray-500">Stock faible</p>
                <p class="text-2xl font-semibold"><span class="badge-low">{{ $lowStockCount }}</span></p>
            </div>
            <div class="panel">
                <p class="text-sm text-gray-500">Ruptures de stock</p>
                <p class="text-2xl font-semibold"><span class="badge-out">{{ $outOfStockCount }}</span></p>
            </div>
        </div>

        <div class="panel mb-6">
            <h3 class="mb-3 text-lg font-semibold">Alertes de stock</h3>
            @if ($alerts->isEmpty())
                <p class="text-gray-500">Aucune alerte : tous les stocks sont au-dessus de leur seuil.</p>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-sm text-gray-600">
                            <th class="py-2 pr-4">Produit</th>
                            <th class="py-2 pr-4">Référence</th>
                            <th class="py-2 pr-4">Catégorie</th>
                            <th class="py-2 pr-4">Stock</th>
                            <th class="py-2 pr-4">Seuil</th>
                            <th class="py-2 text-right">Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alerts as $product)
                            <tr class="border-b border-gray-100">
                                <td class="table-cell font-medium">
                                    <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:underline">{{ $product->name }}</a>
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
            @endif
        </div>

        <div class="panel">
            <h3 class="mb-3 text-lg font-semibold">Répartition par catégorie</h3>
            @if ($perCategory->isEmpty())
                <p class="text-gray-500">Aucune catégorie enregistrée.</p>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-sm text-gray-600">
                            <th class="py-2 pr-4">Catégorie</th>
                            <th class="py-2 pr-4">Produits</th>
                            <th class="py-2 pr-4">Quantité totale</th>
                            <th class="py-2 text-right">Valeur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perCategory as $row)
                            <tr class="border-b border-gray-100">
                                <td class="table-cell font-medium">{{ $row['name'] }}</td>
                                <td class="table-cell">{{ $row['count'] }}</td>
                                <td class="table-cell">{{ $row['quantity'] }}</td>
                                <td class="table-cell text-right">{{ number_format($row['value'], 2, ',', ' ') }} €</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
