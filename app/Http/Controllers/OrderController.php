<?php

namespace App\Http\Controllers;

use App\DataTables\OrdersDataTable;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(OrdersDataTable $datatable)
    {
        return $datatable->render('pages.orders.index');
    }

    public function show(Request $request, $id)
    {
        if (empty($id)) {
            return redirect('/orders')->withWarning("Order was not selected");
        }

        $order = Order::find($id);
        if (!$order) {
            return redirect('/orders')->withError('Order not found');
        }

        return view('pages.orders.view', [
            'order' => $order
        ]);
    }

    public function delete(Request $request) 
    {
        try {
            $order = Order::find($request->input('order_id'));
            if ($order){
                $order->delete();
                return redirect('/orders')->withSuccess('Order deleted successfully!');
            } else {
                return back()->withError('Order not found');
            }
        } catch(\Exception $exception) {
            return redirect('/orders')->withError('Order could not be deleted');
        }
    }
}
