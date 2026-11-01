<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $stockValue = (float) Product::query()
            ->selectRaw('COALESCE(SUM(quantity * price), 0) as value')
            ->value('value');

        $alerts = Product::with('category')
            ->whereColumn('quantity', '<=', 'low_stock_threshold')
            ->orderBy('quantity')
            ->orderBy('name')
            ->get();

        $perCategory = Category::with('products')->orderBy('name')->get()->map(fn (Category $category): array => [
            'name' => $category->name,
            'count' => $category->products->count(),
            'quantity' => $category->products->sum('quantity'),
            'value' => $category->products->sum(fn (Product $product): float => $product->quantity * (float) $product->price),
        ]);

        return view('dashboard', [
            'productsCount' => Product::count(),
            'stockValue' => $stockValue,
            'lowStockCount' => Product::lowStock()->count(),
            'outOfStockCount' => Product::outOfStock()->count(),
            'alerts' => $alerts,
            'perCategory' => $perCategory,
        ]);
    }
}
