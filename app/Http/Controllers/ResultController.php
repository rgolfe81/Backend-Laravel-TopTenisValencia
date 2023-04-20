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
            // Obtenemos ids de los partidos del torneo seleccionado
            // $tennisMatchIds = TennisMatch::where('tournament_id', $tournament_id)->pluck('id')->toArray();

            // Obtenemos los resultados utilizando los ids de los partidos
            // $results = Result::whereIn('id', $tennisMatchIds)->get();

            // Obtenemos mismo resultado que la consulta comentada anterior, pero con los nombres y apellidos de cada jugador y del ganador del partido, de los partidos que se han jugado.
            $results = Result::select('results.*', 'player1.name as player1_name', 'player1.surname as player1_surname', 'player2.name as player2_name', 'player2.surname as player2_surname', 'winner.name as winner_name', 'winner.surname as winner_surname')
            ->join('users as player1', 'results.player1_user_id', '=', 'player1.id')
            ->join('users as player2', 'results.player2_user_id', '=', 'player2.id')
            ->join('users as winner', 'results.winner_user_id', '=', 'winner.id')
            ->join('tennis_matches', 'results.tennis_match_id', '=', 'tennis_matches.id')
            ->where('tennis_matches.tournament_id', $tournament_id)
            ->get();
            
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
