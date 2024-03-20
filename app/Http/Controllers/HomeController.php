<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_products = Product::count();
        $total_orders = Order::count();
        $total_customers = User::where('user_type', User::CLIENT)->whereStatus(User::ACTIVE)->get()->count();
        $popular_products = Product::orderBy('views')->take(5)->get();

        return view('pages.index', [
            'total_products' => $total_products,
            'total_orders' => $total_orders,
            'total_customers' => $total_customers,
            'popular_products' => $popular_products
        ]);
    }
}
