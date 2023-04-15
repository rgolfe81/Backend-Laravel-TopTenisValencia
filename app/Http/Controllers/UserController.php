<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


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
    
}
