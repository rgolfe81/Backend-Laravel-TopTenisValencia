<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TournamentController extends Controller
{
    public function getAllTournaments()
    {
        try {
            $tournaments = Tournament::query()->get();

            if ($tournaments->isEmpty()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "No tournaments found"
                    ],
                    500
                );
            }

            return [
                "success" => true,
                "data" => $tournaments
            ];
        } catch (\Throwable $th) {
            Log::error("GETTING TOURNAMENTS: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting tournaments"
                ],
                500
            );
        }
    }
}
