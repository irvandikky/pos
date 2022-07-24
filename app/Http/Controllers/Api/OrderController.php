<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;

class OrderController extends Controller
{
    public function getCustomer(Request $request) {
        $search = $request->terms;
        $customers = Customer::search($search)->select('id', 'name', 'phone')->get()->map(function ($value) {
            return ['value' => $value->id, 'label' => "$value->name / ($value->phone)"];
        })->toArray();

        return response()->json($customers);
    }

    public function getProduct(Request $request) {
        $search = $request->terms;
        $id = $request->id;
        $products = Product::select('id', 'name')->where('stock', '>', 0)->whereStatus(1)->orderByDesc('price')->get()->map(function ($value) {
            return ['value' => $value->id, 'label' => "$value->name"];
        });
        if($search) {
            $products = Product::search($search)->select('id', 'name')->where('stock', '>', 0)->whereStatus(1)->orderByDesc('price')->get()->map(function ($value) {
                return ['value' => $value->id, 'label' => "$value->name"];
            });
        }

        if($id) {
            $products = Product::whereStatus(1)->where('stock', '>', 0)->select('id', 'price', 'stock', 'name')->findOrFail($id);
        }

        return response()->json($products->toArray());
    }
}
