<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone'    => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Valid phone is required'], 422);
        }

        try {
            $phone = $request->phone;
            $user  = User::wherePhone($phone)->first();
            if ($user) {
                $pin = $this->createPin();
                $user->password = Hash::make($pin);
                return $this->successResponse();
            }else {
                return $this->failedResponse();
            }
        } catch (\Exception $exception) {
            //Log the error
            return $this->failedResponse();
        }
    }

    public function send($pin, $email) {
        // Mail::to($email)->send(new ResetPassword($pin, $email));
    }

    public function createPin()  {
        $pin = rand(1000, 9999);
        return $pin;
    }

    public function failedResponse() {
        return response()->json([
            'error' => 'Phone number does not exist.'
        ], 404);
    }

    public function successResponse() {
        return response()->json([
            'message' => 'Check your inbox, we have sent a link to reset password.'
        ], 200);
    }

    public function changePassword(Request $request) {
        $credentials = $request->only(['phone','current_password','new_password']);

        $validator = Validator::make($credentials, [
            'phone'             => 'required|string',
            'current_password'  => 'required|string',
            'new_password'      => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json('current password and new password are required', 422);
        }

        try {
            $phone = $request->phone ?? '';
            $user = User::where('phone',  $phone)->first();
            if ($user && Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();

                $token = auth('api')->login($user);
                return response()->json([
                    'message'       => 'Password changed successfully',
                    'access_token'  => $token,
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json('Failed to reset password, try again', 500);
    }

    public function confirmPassword(Request $request) {
        $credentials = $request->only(['phone','password','password_confirmation']);

        $validator = Validator::make($credentials, [
            'phone'     => 'required|string',
            'password'  => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()], 422);
        }

        try {
            $phone = $request->phone;
            $user = User::where('phone',  $phone)->first();
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->save();

                $token = auth('api')->login($user);
                return response()->json([
                    'message'       => 'Password changed successfully',
                    'access_token'  => $token,
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json('Failed to reset password, try again', 500);
    }
}
