<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getProfile()
    {
        $user = auth('api')->user();
        return response()->json([
            'user' => (object) array(
                "name" => $user->name,
                "username" => $user->username,
                "email" => $user->email,
                "phone" => $user->phone,
                'referral_code' => $user->referralCode
            )
        ], 200);
    }
}
