<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class CartController extends Controller
{
    public function index(Request $request)
    {
        try {
             
            $user = Auth::user();
            $carts = $user->products()->whereStatus(Cart::STATUS_NEW)->get();

            $cart_list = [];
            foreach($carts as $cart){
                $cart_list[] = array(
                    "id" => $cart->pivot->id,
                    "product_category_id" => $cart->product_category_id,
                    "name" => $cart->name,
                    "price" => $cart->price,
                    "description" => strip_tags($cart->description),
                    "image_path" => $cart->image_path,
                    "quantity" => $cart->pivot->quantity
                );
            }

            return response()->json([
                'cart'          => $cart_list
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'      => 'required|integer',
            'quantity'        => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        try {
            
            $user = Auth::user();
            $product = Product::find($request->product_id);

            if(!$product) {
                return response()->json(['error' => 'Product not found!']);
            }

            if($product->quantity < $request->quantity) {
                return response()->json(['error' => 'There are no enough products for your request!']);
            }

            $cart = Cart::where('user_id', $user->id)->where('product_id', $request->product_id)->first();

            if($cart) {
                return response()->json(['warning' => 'Product already present in cart!']);
            }

            $new_cart = Cart::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);

            if($new_cart) {
                $product->quantity = intval($product->quantity -  $request->quantity);
                $product->update();
            }

            return response()->json(['success' => 'Product added to cart successfully!']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not add to cart']);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'      => 'required|integer',
            'quantity'        => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        try {
            
            $user = Auth::user();
            $product = Product::find($request->product_id);

            if(!$product) {
                return response()->json(['error' => 'Product not found!']);
            }

            $cart = Cart::where('user_id', $user->id)->where('product_id', $request->product_id)->first();
            $cart->quantity = $request->quantity;
            $cart->update();

            return response()->json(['success' => 'Cart updated successfully!']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not update cart']);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $cart = Cart::find($request->id);
            if(!$cart) {
                return response()->json(['error' => 'Product not found in cart!']);
            }
            
            if($cart->delete()){
                return response()->json(['success' => 'Product removed to cart successfully!']);
            }
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
