<x-app-layout>
    <x-slot:header>
        <h2 class="page-title">Modifier la catégorie « {{ $category->name }} »</h2>
    </x-slot:header>

    <div class="page-container">
        <div class="panel max-w-xl">
            <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="form-label">Nom</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" class="form-input">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="button-primary">Enregistrer</button>
                    <a href="{{ route('categories.index') }}" class="button-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
