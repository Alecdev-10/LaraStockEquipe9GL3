<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'created_by',
        'name',
        'sku',
        'quantity',
        'price',
        'low_stock_threshold',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price' => 'decimal:2',
            'low_stock_threshold' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isOutOfStock(): bool
    {
        return $this->quantity === 0;
    }

    public function isLowStock(): bool
    {
        return ! $this->isOutOfStock() && $this->quantity <= $this->low_stock_threshold;
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if ($search) {
            $operator = $query->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';

            $query->where(function (Builder $query) use ($search, $operator): void {
                $query->where('name', $operator, "%{$search}%")
                    ->orWhere('sku', $operator, "%{$search}%");
            });
        }

        return $query;
    }

    public function scopeInCategory(Builder $query, ?int $categoryId): Builder
    {
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query;
    }

    public function scopeLowStock(Builder $query): Builder
    {
        return $query->where('quantity', '>', 0)
            ->whereColumn('quantity', '<=', 'low_stock_threshold');
    }

    public function scopeOutOfStock(Builder $query): Builder
    {
        return $query->where('quantity', 0);
    }
}
