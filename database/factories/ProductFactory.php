<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'created_by' => User::factory(),
            'name' => fake()->words(3, true),
            'sku' => strtoupper(fake()->unique()->bothify('???-####')),
            'quantity' => fake()->numberBetween(5, 60),
            'price' => fake()->randomFloat(2, 0.50, 99.99),
            'low_stock_threshold' => fake()->numberBetween(2, 8),
        ];
    }

    public function lowStock(): static
    {
        return $this->state(fn (array $attributes): array => [
            'low_stock_threshold' => max(5, (int) $attributes['low_stock_threshold']),
            'quantity' => fake()->numberBetween(1, 4),
        ]);
    }

    public function outOfStock(): static
    {
        return $this->state(['quantity' => 0]);
    }
}
