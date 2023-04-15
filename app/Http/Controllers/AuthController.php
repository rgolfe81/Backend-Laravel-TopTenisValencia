<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'surname' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string|min:6|max:12',
                'city' => 'required|string',
                'age' => 'required|integer',
                'phone' => 'required|string',
            ]);

            if ($validator->fails()) {
                return Response()->json($validator->errors(), 400);
            }

            $user = User::create([
                'name' => $request['name'],
                'surname' => $request['surname'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'city' => $request['city'],
                'age' => $request['age'],
                'phone' => $request['phone'],
            ]);

            $token = $user->createToken('apiToken')->plainTextToken;

            $res = [
                "success" => true,
                "message" => "User registered successfully",
                'data' => $user,
                "token" => $token
            ];

            return response()->json(
                $res,
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            Log::error("Register error: " . $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Register error"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user = User::query()->where('email', $request['email'])->first();
            // Validamos si el usuario existe
            if (!$user) {
                return response(
                    ["success" => true, "message" => "User does not exist"], Response::HTTP_NOT_FOUND);
            }
            // Validamos la contraseña
            if (!Hash::check($request['password'], $user->password)) {
                return response(
                    ["success" => true, "message" => "Password is wrong"], Response::HTTP_NOT_FOUND);
            }

            $token = $user->createToken('apiToken')->plainTextToken;

            $res = [
                "success" => true,
                "message" => "User logged successfully",
                "token" => $token
            ];

            return response()->json(
                $res,
                Response::HTTP_ACCEPTED
            );
        } catch (\Throwable $th) {
            Log::error("Login error: " . $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Login error"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
