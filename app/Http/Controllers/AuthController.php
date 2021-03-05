<?php

namespace App\Http\Controllers;

use App\Http\Responses;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    /**
     * Auth user and generate JWT
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            throw new Exception('Email or password incorrect', 401);
        }

        return Responses::Success('Successful authentication', ['token' => $token]);
    }

    /**
     * Register a new user and generate token
     *
     * @param Request $request
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->toJson(), 400);
            }

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user', 'token'), 201);
        } catch (Exception $e) {
            return response()->json(['msg' => 'Unknow error', 'devMsg' => $e->getMessage()], 500);
        }
    }

    /**
     *
     */
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
}