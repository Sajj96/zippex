<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index() 
    {
        $products = Product::lazy();
        return response()->json([ 'products' => $products ]);
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        try {

            $product = Product::find($request->product_id);
            if(!$product){
                return response()->json(['error' => 'Product not found']);
            }

            return response()->json([
                'product'          => $product
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
