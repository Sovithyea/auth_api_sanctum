<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Throwable;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function list()
    {

        Gate::authorize('view', 'products');

        $result = ['status' => 200];

        try {

            $products = Product::all();
            $result['data'] = $products;

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }

    public function store(StoreProductRequest $request)
    {

        Gate::authorize('edit', 'products');

        $result = ['status' => 200];

        try {

            $product = Product::create($request->validated());

            $result['data'] = $product;
            $result['message'] = "Created";

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);
    }

    public function show(Request $request)
    {

        Gate::authorize('view', 'products');

        $result = ['status' => 200];

        try {

            $product = Product::findOrFail($request->id);

            $result['data'] = $product;

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);
    }

    public function update(UpdateProductRequest $request)
    {

        Gate::authorize('edit', 'products');

        $result = ['status' => 200];

        try {

            $product = Product::findOrFail($request->id);
            $product->update($request->validated());

            $result['data'] = $product;
            $result['message'] = "Updated";

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);
    }

    public function delete(Request $request)
    {

        Gate::authorize('edit', 'products');

        $result = ['status' => 200];

        try {

            $product = Product::findOrFail($request->id);
            $product->delete();
            $result['message'] = "Deleted";

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }
}
