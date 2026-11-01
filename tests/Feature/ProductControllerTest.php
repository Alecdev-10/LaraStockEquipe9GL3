<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

test('guests are redirected to login from the product list', function (): void {
    $this->get(route('products.index'))->assertRedirect(route('login'));
});

test('an authenticated manager can create a product with their account as creator', function (): void {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Boissons']);

    $response = $this->actingAs($user)->post(route('products.store'), [
        'name' => 'Thé vert',
        'category_id' => $category->id,
        'sku' => 'THE-001',
        'quantity' => 12,
        'price' => '2.50',
        'low_stock_threshold' => 3,
    ]);

    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseHas('products', [
        'name' => 'Thé vert',
        'category_id' => $category->id,
        'created_by' => $user->id,
        'sku' => 'THE-001',
        'quantity' => 12,
        'price' => '2.50',
    ]);
});

test('product creation reports required fields in French', function (): void {
    $this->actingAs(User::factory()->create())
        ->post(route('products.store'), [])
        ->assertSessionHasErrors([
            'name' => 'Le nom du produit est obligatoire.',
            'category_id' => 'Veuillez choisir une catégorie.',
            'quantity' => 'La quantité est obligatoire.',
            'price' => 'Le prix est obligatoire.',
            'low_stock_threshold' => 'Le seuil d’alerte est obligatoire.',
        ]);

    $this->assertDatabaseCount('products', 0);
});

test('product creation rejects values that exceed the database column limits', function (): void {
    $category = Category::create(['name' => 'Boissons']);

    $this->actingAs(User::factory()->create())
        ->post(route('products.store'), [
            'name' => str_repeat('a', 256),
            'category_id' => $category->id,
            'quantity' => 2147483648,
            'price' => '100000000.00',
            'low_stock_threshold' => 2147483648,
        ])
        ->assertSessionHasErrors([
            'name' => 'Le nom ne peut pas dépasser 255 caractères.',
            'quantity' => 'La quantité maximale autorisée est 2 147 483 647.',
            'price' => 'Le prix ne peut pas dépasser 99 999 999,99.',
            'low_stock_threshold' => 'Le seuil maximal autorisé est 2 147 483 647.',
        ]);

    $this->assertDatabaseCount('products', 0);
});

test('product creation rejects negative stock values, zero price and an unknown category', function (): void {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Hygiène']);
    Product::create([
        'category_id' => $category->id,
        'name' => 'Savon existant',
        'sku' => 'SAV-001',
        'quantity' => 4,
        'price' => '1.00',
        'low_stock_threshold' => 2,
    ]);

    $this->actingAs($user)
        ->post(route('products.store'), [
            'name' => 'Savon nouveau',
            'category_id' => 999,
            'sku' => 'SAV-001',
            'quantity' => -1,
            'price' => '0.00',
            'low_stock_threshold' => -1,
        ])
        ->assertSessionHasErrors([
            'category_id' => 'La catégorie choisie est invalide.',
            'sku' => 'Cette référence est déjà utilisée.',
            'quantity' => 'La quantité ne peut pas être négative.',
            'price' => 'Le prix doit être supérieur à zéro.',
            'low_stock_threshold' => 'Le seuil d’alerte ne peut pas être négatif.',
        ]);

    $this->assertDatabaseCount('products', 1);
});

test('an authenticated manager can update a product without changing its reference', function (): void {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Papeterie']);
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Cahier',
        'sku' => 'CAH-001',
        'quantity' => 8,
        'price' => '1.25',
        'low_stock_threshold' => 2,
    ]);

    $response = $this->actingAs($user)->put(route('products.update', $product), [
        'name' => 'Cahier grand format',
        'category_id' => $category->id,
        'sku' => 'CAH-001',
        'quantity' => 8,
        'price' => '1.50',
        'low_stock_threshold' => 2,
    ]);

    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Cahier grand format',
        'sku' => 'CAH-001',
        'price' => '1.50',
    ]);
});

test('product references must be unique when a product is updated', function (): void {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Hygiène']);
    $firstProduct = Product::create([
        'category_id' => $category->id,
        'name' => 'Savon',
        'sku' => 'SAV-001',
        'quantity' => 4,
        'price' => '1.00',
        'low_stock_threshold' => 2,
    ]);
    $secondProduct = Product::create([
        'category_id' => $category->id,
        'name' => 'Shampoing',
        'sku' => 'SHA-001',
        'quantity' => 4,
        'price' => '3.00',
        'low_stock_threshold' => 2,
    ]);

    $this->actingAs($user)->put(route('products.update', $secondProduct), [
        'name' => 'Shampoing',
        'category_id' => $category->id,
        'sku' => $firstProduct->sku,
        'quantity' => 4,
        'price' => '3.00',
        'low_stock_threshold' => 2,
    ])->assertSessionHasErrors([
        'sku' => 'Cette référence est déjà utilisée.',
    ]);

    $this->assertDatabaseHas('products', ['id' => $secondProduct->id, 'sku' => 'SHA-001']);
});

test('the product list searches by name and reference without regard to case', function (): void {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Boissons']);
    Product::create([
        'category_id' => $category->id,
        'name' => 'Thé vert',
        'sku' => 'THE-202',
        'quantity' => 10,
        'price' => '2.50',
        'low_stock_threshold' => 2,
    ]);

    $this->actingAs($user)
        ->get(route('products.index', ['search' => 'Thé']))
        ->assertOk()
        ->assertSee('Thé vert');

    $this->get(route('products.index', ['search' => 'the-202']))
        ->assertOk()
        ->assertSee('Thé vert')
        ->assertDontSee('Aucun produit trouvé');
});

test('the product list ignores malformed search and category query values', function (): void {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Boissons']);
    Product::create([
        'category_id' => $category->id,
        'name' => 'Thé vert',
        'quantity' => 10,
        'price' => '2.50',
        'low_stock_threshold' => 2,
    ]);

    $this->actingAs($user)
        ->get(route('products.index', ['search' => ['invalide'], 'category_id' => ['invalide']]))
        ->assertOk()
        ->assertSee('Thé vert');
});

test('the product list filters by category and stock state', function (): void {
    $user = User::factory()->create();
    $drinks = Category::create(['name' => 'Boissons']);
    $food = Category::create(['name' => 'Alimentation']);
    Product::create([
        'category_id' => $drinks->id,
        'name' => 'Jus de mangue',
        'quantity' => 2,
        'price' => '1.50',
        'low_stock_threshold' => 3,
    ]);
    Product::create([
        'category_id' => $drinks->id,
        'name' => 'Eau',
        'quantity' => 0,
        'price' => '0.50',
        'low_stock_threshold' => 3,
    ]);
    Product::create([
        'category_id' => $food->id,
        'name' => 'Riz',
        'quantity' => 2,
        'price' => '4.00',
        'low_stock_threshold' => 3,
    ]);

    $this->actingAs($user)
        ->get(route('products.index', ['category_id' => $drinks->id, 'status' => 'low']))
        ->assertOk()
        ->assertSee('Jus de mangue')
        ->assertSee('Stock faible')
        ->assertDontSee('Eau')
        ->assertDontSee('Riz');
});

test('the product list sorts by the selected price order', function (): void {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Boissons']);
    Product::create([
        'category_id' => $category->id,
        'name' => 'Thé',
        'quantity' => 5,
        'price' => '2.00',
        'low_stock_threshold' => 1,
    ]);
    Product::create([
        'category_id' => $category->id,
        'name' => 'Eau',
        'quantity' => 5,
        'price' => '0.50',
        'low_stock_threshold' => 1,
    ]);

    $this->actingAs($user)
        ->get(route('products.index', ['sort' => 'price', 'direction' => 'asc']))
        ->assertOk()
        ->assertSeeInOrder(['Eau', 'Thé']);
});

test('the product list keeps search filters when moving to another page', function (): void {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Alimentation']);

    foreach (range(1, 11) as $number) {
        Product::create([
            'category_id' => $category->id,
            'name' => "Produit courant {$number}",
            'quantity' => 5,
            'price' => '2.00',
            'low_stock_threshold' => 1,
        ]);
    }

    $this->actingAs($user)
        ->get(route('products.index', ['search' => 'Produit courant', 'sort' => 'quantity']))
        ->assertOk()
        ->assertSee('Page 1 sur 2')
        ->assertSee('Suivant')
        ->assertSee('page=2')
        ->assertSee('search=Produit%20courant')
        ->assertSee('sort=quantity');
});

test('an authenticated manager can see stock warnings and delete a product', function (): void {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Alimentation']);
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Farine',
        'quantity' => 0,
        'price' => '2.00',
        'low_stock_threshold' => 2,
    ]);

    $this->actingAs($user)
        ->get(route('products.show', $product))
        ->assertOk()
        ->assertSee('Rupture de stock');

    $this->delete(route('products.destroy', $product))
        ->assertRedirect(route('products.index'));

    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});
