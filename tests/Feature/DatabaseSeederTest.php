<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

test('le seeder crée le compte démo, 6 catégories et 36 produits avec ruptures et stocks faibles', function () {
    $this->seed();

    expect(User::where('email', 'demo@larastock.fr')->exists())->toBeTrue()
        ->and(Category::count())->toBe(6)
        ->and(Product::count())->toBe(36)
        ->and(Product::outOfStock()->count())->toBe(5)
        ->and(Product::lowStock()->count())->toBe(8)
        ->and((float) Product::query()->selectRaw('COALESCE(SUM(quantity * price), 0) as value')->value('value'))->toBeGreaterThan(0.0);
});
