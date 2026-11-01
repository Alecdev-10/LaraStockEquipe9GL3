<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

test('un invité est redirigé vers la connexion depuis le tableau de bord', function () {
    $this->get('/')->assertRedirect(route('login'));
});

test('le tableau de bord affiche les statistiques du stock', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create(['name' => 'Boissons']);

    Product::factory()->create([
        'category_id' => $category->id,
        'quantity' => 0,
        'price' => '2.50',
        'low_stock_threshold' => 5,
    ]);
    Product::factory()->create([
        'category_id' => $category->id,
        'quantity' => 10,
        'price' => '1.00',
        'low_stock_threshold' => 5,
    ]);

    $this->actingAs($user)
        ->get('/')
        ->assertOk()
        ->assertSee('Tableau de bord')
        ->assertSee('Boissons')
        ->assertSee('Ruptures de stock')
        ->assertSee('Alertes de stock');
});
