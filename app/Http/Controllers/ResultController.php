<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\Result;
use App\Models\TennisMatch;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResultController extends Controller
{
    public function updateResultbyIdToTennisMatch(Request $request, $id){
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
            Log::info("Update result to match");

            // Actualizar datos en clasificación

            // Obtenemos el id del partido que es el mismo que el id de result
            $tennisMatch = TennisMatch::find($id);
            // Obtenemos el torneo del partido indicado
            $tournament = $tennisMatch->tournament_id;

            // Conseguimos el registro de la clasificación del torneo que coincide con el ganador del partido
            $classificationWinner = Classification::where('tournament_id', $tournament)
            ->where('user_id', $winnerMatch)
            ->first();

            // Incrementamos los valores de las puntuaciones del ganador del partido
            $scoreWinner = $classificationWinner->score;
            $matchesPlayedWinner = $classificationWinner->matches_played;
            $matchesWinWinner = $classificationWinner->matches_win;

            $classificationWinner->score = $scoreWinner + 2;
            $classificationWinner->matches_played = $matchesPlayedWinner + 1;
            $classificationWinner->matches_win = $matchesWinWinner +1;

            // Obtenemos el perdedor del partido
            if ($winnerMatch === $player1){
                $loserMatch = $player2;
            } else {
                $loserMatch = $player1;
            }

            // Conseguimos el registro de la clasificación del torneo que coincide con el perdedor del partido
            $classificationLoser = Classification::where('tournament_id', $tournament)
            ->where('user_id', $loserMatch)
            ->first();

            // Incrementamos los valores de las puntuaciones del perdedor del partido
            $scoreLoser = $classificationLoser->score;
            $matchesPlayedLoser = $classificationLoser->matches_played;
            $matchesLostLoser = $classificationLoser->matches_lost;

            $classificationLoser->score = $scoreLoser + 1;
            $classificationLoser->matches_played = $matchesPlayedLoser + 1;
            $classificationLoser->matches_lost = $matchesLostLoser +1;

            $classificationWinner->save();
            $classificationLoser->save();
            Log::info("Updated players score on classification");

            return response()->json(
                [
                    "success" => true,
                    "data result" => $result, 
                    "data winner classification" => $classificationWinner,
                    "data loser classification" => $classificationLoser,
                    "data tennisMatch" => $tennisMatch
                ],
                200
            );

        } catch (\Throwable $th) {
            Log::error("UPDATING RESULT: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error updating result"
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

    public function getResultsByTournamentIdForMatches($tournament_id){
        try {
            // Obtenemos mismo resultado que el controlador anterior 'getResultsByTournamentId' con los partidos aún sin jugar, con del campo vacío 'winner_user', para poder listar con los partidos por disputar

            $results = Result::select('results.*', 'player1.name as player1_name', 'player1.surname as player1_surname', 'player2.name as player2_name', 'player2.surname as player2_surname', 'winner.name as winner_name', 'winner.surname as winner_surname')
            ->leftJoin('users as player1', 'results.player1_user_id', '=', 'player1.id')
            ->leftJoin('users as player2', 'results.player2_user_id', '=', 'player2.id')
            ->leftJoin('users as winner', 'results.winner_user_id', '=', 'winner.id')
            ->leftJoin('tennis_matches', 'results.tennis_match_id', '=', 'tennis_matches.id')
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

    public function getResultsByTournamentIdForWinner($tournament_id){
        try {
            // Obtenemos mismo resultado que el controlador anterior 'getResultsByTournamentIdForWinners' con los partidos el usuario logeado aún sin jugar
            $user_id = Auth::id();

            $results = Result::select('results.*', 'player1.name as player1_name', 'player1.surname as player1_surname', 'player2.name as player2_name', 'player2.surname as player2_surname', 'winner.name as winner_name', 'winner.surname as winner_surname')
            ->leftJoin('users as player1', 'results.player1_user_id', '=', 'player1.id')
            ->leftJoin('users as player2', 'results.player2_user_id', '=', 'player2.id')
            ->leftJoin('users as winner', 'results.winner_user_id', '=', 'winner.id')
            ->leftJoin('tennis_matches', 'results.tennis_match_id', '=', 'tennis_matches.id')
            ->where('tennis_matches.tournament_id', $tournament_id)
            ->where(function ($query) use ($user_id) {
                $query->where('results.player1_user_id', $user_id)
                      ->orWhere('results.player2_user_id', $user_id);
            })
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
