<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\TennisMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResultController extends Controller
{
    public function addResultbyIdToTennisMatch(Request $request, $id){
        try {
            $result = Result::find($id);

            if (!$result) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Tennis match result doesn't exists",
                    ],
                    404
                );
            }

            $player1 = $result->player1_user_id;
            $player2 = $result->player2_user_id;
            $winnerMatch = $request->input('winner_user_id');

            if ($player1 != $winnerMatch && $player2 != $winnerMatch) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "The winner user does not belong to this tennis match",
                    ],
                    403
                );
            }

            if (isset($winnerMatch)) {
                $result->winner_user_id = $winnerMatch;
            }

            $result->save();
            Log::info("Add result to match");

            return response()->json(
                [
                    "success" => true,
                    "data" => $result
                ],
                200
            );

        } catch (\Throwable $th) {
            Log::error("CREATING RESULT: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating result"
                ],
                500
            );
        }    
    }

    public function getResultsByTournamentId($tournament_id){
        try {
            // Obtener los IDs de partidos de tenis del torneo
            $tennisMatchIds = TennisMatch::where('tournament_id', $tournament_id)->pluck('id')->toArray();
            
            // Obtener los IDs de resultados a partir de los IDs de partidos de tenis
            $resultIds = Result::whereIn('tennis_match_id', $tennisMatchIds)->pluck('id')->toArray();

            // Obtener los resultados utilizando los IDs de resultados
            $results = Result::whereIn('id', $resultIds)->get();
    
            return response()->json(
                [
                    "success" => true,
                    "data" => $results
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("GETTING RESULTS BY TOURNAMENT: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting results by tournament"
                ],
                500
            );
        }
    }
    
}
