<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Order::class);

        $search = $request->get('terms', '');
        $orders = Order::search($search)->with('customer', 'orderDetails')->latest()
            ->paginate(10)
            ->withQueryString();
        return Inertia::render(
            'Orders/Index',
            [
                'orders' => $orders,
            ]
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Order::class);

        return Inertia::render('Orders/Create');
    }

    /**
     * @param \App\Http\Requests\OrderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStoreRequest $request)
    {
        $this->authorize('create', Order::class);

        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        try {
            DB::beginTransaction();
            $productArray = [];

            for ($i = 0; $i < count($validated['products']); $i++) {
                $product = Product::select('id', 'price', 'stock')->findOrFail($validated['products'][$i]['id']);
                if ($product->stock > 0) {
                    $productArray[] = ['product_id' => $product->id, 'qty' => $validated['products'][$i]['qty'], 'total' => $validated['products'][$i]['qty'] * $product->price];
                    $product->update([
                        'stock' => $product->stock - $validated['products'][$i]['qty']
                    ]);
                }
            }

            $order = Order::create($validated);
            $order->orderDetails()->createMany($productArray);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()->withInput($request->all())
                ->withMessage(__('Failed to create Order'));
        }
        return redirect()
            ->route('orders.show', $order)
            ->withMessage(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Order $order)
    {
        $this->authorize('view', $order);
        $order->customer;
        $order->user;
        return Inertia::render('Orders/View', ['orders' => $order, 'details' => $order->orderDetails()->with('product')->get()]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        $detail = $order->orderDetails()->with('product')->get()->map(function ($value) {
            return ['id' => $value->product->id, 'name' => $value->product->name, 'qty' => $value->qty, 'subprice' => $value->total, 'price' => $value->product->price, 'disabled' => true];
        })->toArray();

        return Inertia::render('Orders/Edit', ['orders' => $order, 'details' => $detail]);
    }

    /**
     * @param \App\Http\Requests\OrderUpdateRequest $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateRequest $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        try {
            DB::beginTransaction();
            $productArray = [];

            $order->orderDetails()->delete();
            for ($i = 0; $i < count($validated['products']); $i++) {
                $product = Product::select('id', 'price', 'stock')->findOrFail($validated['products'][$i]['id']);
                if ($product->stock > 0) {
                    $productArray[] = ['product_id' => $product->id, 'qty' => $validated['products'][$i]['qty'], 'total' => $validated['products'][$i]['qty'] * $product->price];
                    $product->update([
                        'stock' => $product->stock - $validated['products'][$i]['qty']
                    ]);
                }
            }
            $order->update($validated);
            $order->orderDetails()->createMany($productArray);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()->withInput($request->all())
                ->withMessage(__('Failed to update Order'));
        }

        return redirect()
            ->route('orders.edit', $order)
            ->withMessage(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Order $order)
    {
        $this->authorize('delete', $order);

        $order->delete();
        $order->orderDetails()->delete();

        return redirect()
            ->route('orders.index')
            ->withMessage(__('crud.common.removed'));
    }
}
