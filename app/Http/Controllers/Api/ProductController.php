<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Add Product
    public function store(Request $request) {
        $product = Product::create([
            'name' => $request->name,
            'details' => $request->details
        ]);

        if(!$product) {
            return response()->json(['message'=>'You must login to add product']);
        }

        return response()->json(['message'=>'Product Added Successfully', $product]);
    }
}
