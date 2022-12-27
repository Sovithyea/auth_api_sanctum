<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Throwable;

class ProductController extends Controller
{
    public function index()
    {

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

    public function show($id)
    {

        $result = ['status' => 200];

        try {

            $product = Product::find($id);

            $result['data'] = $product;

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }

    public function edit($id)
    {

        $result = ['status' => 200];

        try {

            $product = Product::find($id);

            $result['data'] = $product;

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }

    public function update($id, UpdateProductRequest $request)
    {

        $result = ['status' => 200];

        try {

            $product = Product::find($id);
            $product->update($request->validated());

            $result['data'] = $product;
            $result['message'] = "Updated";

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }

    public function destroy($id)
    {

        $result = ['status' => 200];

        try {

            Product::destroy($id);

            $result['message'] = "Deleted";

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }

    public function search($name)
    {

        $result = ['status' => 200];

        try {

            $products = Product::where('name', 'like', '%'.$name.'%')->get();

            $result['data'] = $products;

        } catch (Throwable $e) {
            $result['status'] = 201;
            $result['message'] = $e->getMessage();
        }

        return response()->json($result);

    }
}
