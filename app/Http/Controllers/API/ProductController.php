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
        $products = Product::get();
        $product_list = [];
        foreach($products as $product) {
            $product_list[] = array(
                    "id" => $product->id,
                    "product_category_id" => $product->product_category_id,
                    "name" => $product->name,
                    "price" => $product->price,
                    "description" => strip_tags($product->description),
                    "quantity" => $product->quantity,
                    "image_path" => $product->image_path
            );
        }
        return response()->json([ 'products' => $product_list ]);
    }

    public function show(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            if(!$product){
                return response()->json(['error' => 'Product not found']);
            }

            return response()->json([
                'product'          => (object) array(
                    "id" => $product->id,
                    "product_category_id" => $product->product_category_id,
                    "name" => $product->name,
                    "price" => $product->price,
                    "description" => strip_tags($product->description),
                    "quantity" => $product->quantity,
                    "image_path" => $product->image_path
                )
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
