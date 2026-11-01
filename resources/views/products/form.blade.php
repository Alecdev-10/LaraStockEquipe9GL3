<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="name" class="form-label">Nom du produit</label>
        <input id="name" name="name" maxlength="255" value="{{ old('name', $product->name ?? '') }}" required class="form-input">
        @error('name') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="category_id" class="form-label">Catégorie</label>
        <select id="category_id" name="category_id" required class="form-input">
            <option value="">Choisir une catégorie</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id') <p class="form-error">{{ $message }}</p> @enderror
        @if ($categories->isEmpty()) <p class="mt-2 text-sm text-amber-700">Ajoutez d’abord une catégorie.</p> @endif
    </div>

    <div>
        <label for="sku" class="form-label">Référence (facultative)</label>
        <input id="sku" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="form-input">
        @error('sku') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="quantity" class="form-label">Quantité</label>
        <input id="quantity" name="quantity" type="number" min="0" max="2147483647" value="{{ old('quantity', $product->quantity ?? 0) }}" required class="form-input">
        @error('quantity') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="price" class="form-label">Prix unitaire</label>
        <input id="price" name="price" type="number" min="0.01" max="99999999.99" step="0.01" value="{{ old('price', $product->price ?? '') }}" required class="form-input">
        @error('price') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="low_stock_threshold" class="form-label">Seuil d’alerte</label>
        <input id="low_stock_threshold" name="low_stock_threshold" type="number" min="0" max="2147483647" value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}" required class="form-input">
        @error('low_stock_threshold') <p class="form-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex flex-wrap gap-3">
    <button class="button-primary">{{ $buttonText }}</button>
    <a href="{{ route('products.index') }}" class="button-secondary">Annuler</a>
</div>
