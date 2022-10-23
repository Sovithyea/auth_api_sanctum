<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required'
        ]);
        $product = Product::create($request->all());

        if($product)
        {
            return response()->json([
                'message' => 'Successfully create'
            ]);
        } else {
            return response()->json([
                'message' => 'Error'
            ]);
        }
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    public function update($id, Request $request)
    {
        // dd($id);
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required'
        ]);
        $product->update($request->all());

        if($product)
        {
            return response()->json([
                'message' => 'Successfully update'
            ]);
        } else {
            return response()->json([
                'message' => 'Error'
            ]);
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Successfully Delete']);
    }

    public function search($name)
    {
        $products = Product::where('name', 'like', '%'.$name.'%')->get();

        return response()->json($products);
    }
}
