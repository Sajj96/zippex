<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string',
            'username'      => 'required|string|unique:users',
            'phone'         => 'required|string|min:11|unique:users',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        $user = User::whereUsername($request->username)->wherePhone($request->phone)->first();
        if (!$user) {
            $user_type = (int) substr($request->referrer_code,-1);
            $phone = '255' . substr($request->referrer_code,0,9);
            $referrer = User::wherePhone($phone)->where('user_type', $user_type)->first();

            $user = new User;
            $user->name          = $request->name;
            $user->username      = $request->username;
            $user->phone         = $request->phone;
            $user->email         = $request->email;
            $user->country       = $request->country;
            $user->password      = Hash::make($request->password);
            $user->user_type     = User::CLIENT;
            $user->referrer_id   = $referrer ? $referrer->id : null;
            $user->status        = User::ACTIVE;

            if (!$user->save()) {

                return response()->json(['error' => 'Oops!. Something went wrong during registration. Please try again.']);
            } else {
                $token = auth('api')->login($user);

                return response()->json([
                    'message'       => 'Account created successfully',
                    'access_token'  => $token,
                    'token_type'    => 'bearer',
                    'user'          => $user
                ], 201);
            }
        }

        return response()->json(['error' => 'User with the provided details is present!']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['phone', 'password']);
        $validator = Validator::make($credentials, [
            'phone'     => 'required|string',
            'password'  => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Valid phone number and password are required'], 422);
        }

        try {

            $user = User::wherePhone($request->phone)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                $token = auth('api')->login($user);
                return $this->respondWithToken($token, $user);
            } else {
                return response()->json(['error' => 'Login failed, Check your phone and password and try again']);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create booking'], 500);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function me()
    {
        try {
            $me = auth('api')->user();

            return response()->json([
                'me' => $me
            ], 200);
            return response()->json($me);
        } catch (\Throwable $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function logout()
    {
        if (!is_null(auth('api')->user()) && auth('api')->logout()) {
            return response()->json(['message' => 'Successfully logged out'], 200);
        }
        return response()->json(['message' => 'User not Authenticated'], 401);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user = null)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => null,
            'user' => (object) array(
                "name" => $user->name,
                "username" => $user->username,
                "email" => $user->email,
                "phone" => $user->phone
            )
        ]);
    }
}
