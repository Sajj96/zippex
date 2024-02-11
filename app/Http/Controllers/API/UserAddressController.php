<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'      => 'required|integer',
            'quantity'        => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }
    }
}
