<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $sort = $request->query('sort', 'name');
        $direction = $request->query('direction', 'asc');
        $search = $request->query('search');
        $categoryId = $request->query('category_id');

        if (! is_string($search)) {
            $search = null;
        }

        if (! is_string($categoryId) || ! ctype_digit($categoryId)) {
            $categoryId = null;
        } else {
            $categoryId = (int) $categoryId;
        }

        if (! in_array($sort, ['name', 'price', 'quantity'], true)) {
            $sort = 'name';
        }

        if (! in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $products = Product::with('category')
            ->search($search)
            ->inCategory($categoryId)
            ->when($status === 'low', fn ($query) => $query->lowStock())
            ->when($status === 'out', fn ($query) => $query->outOfStock())
            ->orderBy($sort, $direction)
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    public function create(): View
    {
        return view('products.create', ['categories' => Category::orderBy('name')->get()]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->validated() + ['created_by' => $request->user()->id]);

        return redirect()->route('products.index')->with('success', 'Le produit a été ajouté.');
    }

    public function show(Product $product): View
    {
        return view('products.show', ['product' => $product->load('category')]);
    }

    public function edit(Product $product): View
    {
        return view('products.edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('products.index')->with('success', 'Le produit a été modifié.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Le produit a été supprimé.');
    }
}
