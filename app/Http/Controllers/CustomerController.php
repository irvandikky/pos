<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use Inertia\Inertia;

class CustomerController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Customer::class);

        $customers = Customer::latest()
        ->paginate(10);

        return Inertia::render(
            'Customers/Index',
            [
                'customers' => $customers,
            ]
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Customer::class);

        return view('app.customers.create');
    }

    /**
     * @param \App\Http\Requests\CustomerStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerStoreRequest $request)
    {
        $this->authorize('create', Customer::class);

        $validated = $request->validated();
        $validated['address'] = json_decode($validated['address'], true);

        $customer = Customer::create($validated);

        return redirect()
            ->route('customers.edit', $customer)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Customer $customer)
    {
        $this->authorize('view', $customer);

        return view('app.customers.show', compact('customer'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        return view('app.customers.edit', compact('customer'));
    }

    /**
     * @param \App\Http\Requests\CustomerUpdateRequest $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $validated = $request->validated();
        $validated['address'] = json_decode($validated['address'], true);

        $customer->update($validated);

        return redirect()
            ->route('customers.edit', $customer)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}