<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function index() 
    {
        $categories = ProductCategory::get();
        return response()->json([ 'product_categories' => $categories ]);
    }

    public function getProducts(Request $request, $id)
    {
        try {
            $category = ProductCategory::find($id);
            if(!$category){
                return response()->json(['error' => 'Product category not found']);
            }

            $products = $category->products;
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

            return response()->json([
                'products'          => $product_list
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
