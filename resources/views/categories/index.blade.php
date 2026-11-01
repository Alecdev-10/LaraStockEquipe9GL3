<x-app-layout>
    <x-slot:header>
        <h2 class="page-title">Catégories</h2>
    </x-slot:header>

    <div class="page-container">
        <div class="panel mb-6">
            <form method="POST" action="{{ route('categories.store') }}" class="flex items-end gap-4">
                @csrf
                <div class="flex-1">
                    <label for="name" class="form-label">Nouvelle catégorie</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" class="form-input" placeholder="Ex. Épicerie">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="button-primary">Ajouter</button>
            </form>
        </div>

        <div class="panel">
            @if ($categories->isEmpty())
                <p class="text-gray-500">Aucune catégorie pour le moment.</p>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-sm text-gray-600">
                            <th class="py-2 pr-4">Nom</th>
                            <th class="py-2 pr-4">Produits</th>
                            <th class="py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr class="border-b border-gray-100">
                                <td class="table-cell font-medium">{{ $category->name }}</td>
                                <td class="table-cell">{{ $category->products_count }}</td>
                                <td class="table-cell text-right">
                                    <a href="{{ route('categories.edit', $category) }}" class="text-indigo-600 hover:underline">Modifier</a>
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Supprimer la catégorie « {{ $category->name }} » ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-3 text-red-600 hover:underline">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
