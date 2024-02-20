<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {

            $user = Auth::user();
            $orders = $user->orders()->with('cart')->get();

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
            'user_address_id' => 'required|integer',
            'carts' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        try {
            
            $user = Auth::user();
            $address = UserAddress::where('user_id',$user->id)->whereId($request->user_address_id)->first();

            if(!$address) {
                return response()->json(['warning' => 'Address not found!']);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'code' => "ORD".Order::getToken(6),
                'user_address_id' => $request->user_address_id,
                'status' => Order::STATUS_PENDING
            ]);

            if($order){
                foreach($request->carts as $cart) {
                    $check_cart = Cart::find($cart);
                    if($check_cart) {
                        OrderItem::updateOrCreate(
                            [
                                "order_id" => $order->id,
                                "cart_id" => $check_cart->id
                            ],
                            [
                                "order_id" => $order->id,
                                "cart_id" => $check_cart->id,
                                "amount" => $check_cart->quantity * $check_cart->productPrice
                            ]
                        );
                        $check_cart->status = Cart::STATUS_CHECKEDOUT;
                        $check_cart->update();
                    }
                }
            }

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
