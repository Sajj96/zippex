<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserAddressController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'  => 'required|integer',
            'street'   => 'required|string',
            'ward'     => 'required|string',
            'district' => 'required|string',
            'region'   => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        try {
            
            $user = User::find($request->user_id);

            if($user) {
                return response()->json(['warning' => 'User not found!']);
            }

            $address = UserAddress::create([
                'user_id' => $user->id,
                'street' => $request->street,
                'ward' => $request->ward,
                'district' => $request->district,
                'region' => $request->region,
                'country' => $request->country,
            ]);

            return response()->json(['success' => 'Address added successfully!']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not add address']);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
