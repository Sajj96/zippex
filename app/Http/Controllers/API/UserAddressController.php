<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserAddressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->addresses;
        $address_list = [];
        foreach($addresses as $address) {
            $address_list[] = array(
                "id" => $address->id,
                "user_id" => $address->user_id,
                "street" => $address->street,
                "ward" => $address->ward,
                "district" => $address->district,
                "region" => $address->region,
                "country" => $user->country,
            );
        }

        return response()->json([
            "addresses" => $address_list
        ]);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'street'   => 'required|string',
            'ward'     => 'required|string',
            'district' => 'required|string',
            'region'   => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        try {
            
            $user = Auth::user();

            $address = UserAddress::where('user_id', $user->id)->where('street', $request->street)->where('ward', $request->ward)->where('district', $request->district)->first();

            if(!$address) {
                UserAddress::create([
                    'user_id' => $user->id,
                    'street' => $request->street,
                    'ward' => $request->ward,
                    'district' => $request->district,
                    'region' => $request->region,
                    'country' => $request->country,
                ]);

                return response()->json(['success' => 'Address added successfully!']);
            }

            return response()->json(['warning' => 'Address already exists!']);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not add address']);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
