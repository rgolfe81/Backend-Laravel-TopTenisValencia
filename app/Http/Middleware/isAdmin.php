<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (auth()->user()->role_id == 2) 
            {
                return $next($request);              
            }
            Log::info('No administrator permissions');
            return response()->json([
                'success' => false,
                'message' => 'No administrator permissions'
            ], 401);

        } catch (\Throwable $th) {
            Log::error("isAdmin middleware error: " . $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => $th->getMessage()
                ],500);
        }
    }
}
