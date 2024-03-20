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
                "referral_code" => $user->referralCode,
                "package" => $user->package
            )
        ], 200);
    }

    public function getDownlines()
    {
        $user = auth('api')->user();
    
        $levelOne = $user->getLevelData($user->id, 1, $user->packageLevelOne);
        $levelTwo = $user->getLevelData($user->id, 2, $user->packageLevelTwo);
        $levelThree = $user->getLevelData($user->id, 3, $user->packageLevelThree);
    
        return response()->json([
            'level_one' => $levelOne,
            'level_two' => $levelTwo,
            'level_three' => $levelThree
        ]);
    }
}
