<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        try {

            $order = Order::whereId($request->user_id)->with('items')->get();
            if(!$order){
                return response()->json(['error' => 'Order not found']);
            }

            return response()->json([
                'orders'          => $order
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'      => 'required|integer',
            'user_address' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        try {
            
            $user = Auth::user();
            $order = Order::find($user->id);

            if($order) {
                return response()->json(['warning' => 'Product already present in cart!']);
            }

            $new_order = Order::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);

            if($new_order) {

            }

            return response()->json(['success' => 'Product added to cart successfully!']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not add to cart']);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $order = Order::find($request->id);
            if(!$order) {
                return response()->json(['error' => 'Order not found!']);
            }
            
            if($order->delete()){
                return response()->json(['success' => 'Order was deleted successfully!']);
            }
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
