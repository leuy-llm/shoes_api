<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return new ProductCollection($products);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return new ProductResource(new Product());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();
            $product = Product::create($validated);
            return response()->json([
                 'rows' => [new ProductResource($product)]
            ],201);
        } catch (\Exception $e) {
            return response()->json([
                 'error' => $e->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json([
             'rows' => [new ProductResource($product)]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
             'rows' => [new ProductResource($product)]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $validated = $request->validated(); // Validate the request
            $product = Product::findOrFail($id);
            $product->fill($validated); // Use the validated data
            $product->save();
            return response()->json([
                 'rows' => [new ProductResource($product)]
            ],201);
        } catch (\Exception $e) {
            return response()->json([
                 'error' => $e->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
             'rows' => [new ProductResource($product)]
        ]);
    }
}
