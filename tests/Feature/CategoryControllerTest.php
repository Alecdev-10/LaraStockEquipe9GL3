<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('un invité est redirigé vers la connexion depuis les catégories', function () {
    $this->get(route('categories.index'))->assertRedirect(route('login'));
});

test('la liste des catégories affiche le nombre de produits', function () {
    $category = Category::factory()->create(['name' => 'Boissons']);
    Product::factory()->count(2)->create(['category_id' => $category->id]);

    $this->actingAs($this->user)
        ->get(route('categories.index'))
        ->assertOk()
        ->assertSee('Boissons')
        ->assertSee('2');
});

test('on peut ajouter une catégorie', function () {
    $this->actingAs($this->user)
        ->post(route('categories.store'), ['name' => 'Épicerie'])
        ->assertRedirect(route('categories.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('categories', ['name' => 'Épicerie']);
});

test('le nom de la catégorie est obligatoire', function () {
    $this->actingAs($this->user)
        ->post(route('categories.store'), ['name' => ''])
        ->assertSessionHasErrors(['name' => 'Le nom de la catégorie est obligatoire.']);
});

test('le nom de la catégorie doit être unique', function () {
    Category::factory()->create(['name' => 'Boissons']);

    $this->actingAs($this->user)
        ->post(route('categories.store'), ['name' => 'Boissons'])
        ->assertSessionHasErrors(['name' => 'Cette catégorie existe déjà.']);
});

test('on peut modifier une catégorie', function () {
    $category = Category::factory()->create(['name' => 'Ancien nom']);

    $this->actingAs($this->user)
        ->put(route('categories.update', $category), ['name' => 'Nouveau nom'])
        ->assertRedirect(route('categories.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Nouveau nom']);
});

test('une catégorie contenant des produits ne peut pas être supprimée', function () {
    $category = Category::factory()->create(['name' => 'Boissons']);
    Product::factory()->create(['category_id' => $category->id]);

    $response = $this->actingAs($this->user)->delete(route('categories.destroy', $category));

    $response->assertRedirect(route('categories.index'));
    $response->assertSessionHas('error');
    $this->assertDatabaseHas('categories', ['id' => $category->id]);
});

test('une catégorie vide peut être supprimée', function () {
    $category = Category::factory()->create();

    $this->actingAs($this->user)
        ->delete(route('categories.destroy', $category))
        ->assertRedirect(route('categories.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});
