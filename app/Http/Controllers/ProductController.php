<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Product::class);

        $search = $request->get('terms', '');
        $products = Product::search($search)->latest()
        ->paginate(10)
        ->withQueryString();

        return Inertia::render(
            'Products/Index',
            [
                'products' => $products,
            ]
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Product::class);

        $categories = Category::select('id', 'name')->get()->map(function($value) {
            return ['value' => $value->id, 'label' => $value->name];
        })->toArray();
        return Inertia::render('Products/Create', [
            'categories' => $categories,
        ]);
    }

    /**
     * @param \App\Http\Requests\ProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }
        $categories = array_map(function($value) {return $value['value'];}, $validated['categories']);
        $validated['status'] = intval($validated['status']) ;
        $product = Product::create($validated);
        $product->categories()->sync($categories);

        return redirect()
            ->route('products.edit', $product)
            ->withMessage(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        $this->authorize('view', $product);
        $product['image'] = $product->image ? \Storage::url($product->image) : null;

        return Inertia::render(
            'Products/View',
            [
                'products' => $product,
            ]
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $categories = Category::select('id', 'name')->get()->map(function($value) {
            return ['value' => $value->id, 'label' => $value->name];
        })->toArray();

        $product['image'] = $product->image ? \Storage::url($product->image) : null;
        $product['categories'] = $product->categories()->get()->map(function($value) {
            return ['value' => $value->id, 'label' => $value->name];
        })->toArray();

        return Inertia::render(
            'Products/Edit',
            [
                'products' => $product,
                'categories' => $categories,
            ]
        );
    }

    /**
     * @param \App\Http\Requests\ProductUpdateRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $validated = $request->validated();
        $categories = array_map(function($value) {return $value['value'];}, $validated['categories']);
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete($product->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }
        $product->update($validated);
        $product->categories()->sync($categories);

        return redirect()
            ->route('products.edit', $product)
            ->withMessage(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        $this->authorize('delete', $product);

        if ($product->image) {
            Storage::delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->withMessage(__('crud.common.removed'));
    }
}
