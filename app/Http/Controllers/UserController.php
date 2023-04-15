<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function profile()
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response([
                "success" => false,
                "message" => "User not authenticated"
            ], Response::HTTP_UNAUTHORIZED);
        }
    
        // Obtener detalles del usuario
        $user = auth()->user();
    
        return response([
            "success" => true,
            "message" => "User profile retrieved successfully",
            "data" => $user
        ], Response::HTTP_OK);
    }
    
    public function updateUser(Request $request, $id)
    {
        try {
            // Verificar si el usuario está autenticado
            if (!auth()->check()) {
                return response([
                    "success" => false,
                    "message" => "User not authenticated"
                ], Response::HTTP_UNAUTHORIZED);
            }
            
            $validator = Validator::make($request->all(), [
                'name' => 'regex:/^[a-zA-ZñÑáÁéÉíÍóÓúÚüÜ\s]+$/',
                'surname' => 'regex:/^[a-zA-ZñÑáÁéÉíÍóÓúÚüÜ]+(\s[a-zA-ZñÑáÁéÉíÍóÓúÚüÜ]+)?$/',
                'city' => 'regex:/^[a-zA-ZñÑáÁéÉíÍóÓúÚüÜ]+(\s[a-zA-ZñÑáÁéÉíÍóÓúÚüÜ]+)*$/',
                'age' => 'regex:/^[1-9][0-9]?$/',
                'phone' => 'regex:/^[0-9]{9}$/'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Obtener detalles del usuario
            $user = User::find($id);

            if (!$user) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "User doesn't exists",
                    ],
                    404
                );
            }

            $name = $request->input('name');
            $surname = $request->input('surname');
            $city = $request->input('city');
            $age = $request->input('age');
            $phone = $request->input('phone');

            if (isset($name)) {
                $user->name = $request->input('name');
            }
            if (isset($surname)) {
                $user->surname = $request->input('surname');
            }
            if (isset($city)) {
                $user->city = $request->input('city');
            }
            if (isset($age)) {
                $user->age = $request->input('age');
            }
            if (isset($phone)) {
                $user->phone = $request->input('phone');
            }

            $user->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User updated",
                    "data" => $user
                ],
                200
            );

        } catch (\Throwable $th){
            Log::error("Register error: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => $th->getMessage()
                ],
                500
            );
        }
    }
}
