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

            $user = Auth::user();
            $orders = $user->orders()->with('items')->get();

            return response()->json([
                'orders'          => $orders
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        try {

            $user = Auth::user();
            $order = Order::where('user_id', $user->id)->whereId($request->order_id)->with('items')->get();
            if(!$order){
                return response()->json(['error' => 'Order not found']);
            }

            return response()->json([
                'order'          => $order
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'         => 'required|integer',
            'user_address_id' => 'required|integer'
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

            Order::create([
                'user_id' => $user->id,
                'user_address_id' => $request->user_address_id,
                'status' => Order::STATUS_PENDING
            ]);

            return response()->json(['success' => 'Order created successfully!']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create order']);
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
