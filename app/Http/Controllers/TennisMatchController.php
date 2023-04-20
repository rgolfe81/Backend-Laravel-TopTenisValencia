<?php

namespace App\Http\Controllers;

use App\Models\TennisMatch;
use App\Models\Tournament;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TennisMatchController extends Controller
{
    public function createMatchToTournamentId(Request $request, $tournament_id)
    {
        try {
            $tournament = Tournament::find($tournament_id);
            $player1 = $request->input('player1_user_id');
            $player2 = $request->input('player2_user_id');
            $userId = Auth::id();

            if (!$tournament) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Tournament 404 not found"
                    ],
                    404
                );
            }

            $isPlayer1Registered = $tournament->users->contains('id', $player1);
            $isPlayer2Registered = $tournament->users->contains('id', $player2);
    
            if (!$isPlayer1Registered || !$isPlayer2Registered) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Some player are not registered at selected tournament"
                    ],
                    403
                );
            }

            $tennisMatch = new TennisMatch();
            $tennisMatch->tournament_id = $tournament_id;
            $tennisMatch->date = $request->input('date');
            $tennisMatch->location = $request->input('location');
            $tennisMatch->save();
            

            $tennisMatchId = $tennisMatch->id;
            $tennisMatch->users()->attach(
                $player1, [
                    'player1_user_id' => $player1,
                    'player2_user_id' => $player2,
                    'user_id' => $userId,
                    'tennis_match_id' => $tennisMatchId
                ]
            );

            Log::info("Add Match to Tournament");

            return response()->json(
                [
                    "success" => true,
                    "data" => $tennisMatch
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error('Error adding match to tournament: ' . $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => 'Error adding match to tournament'
                ],
                500
            );
        }
    }

    public function getMatchesbyTournamentId($tournament_id){
        try {
            $tournament = Tournament::find($tournament_id);
            if (!$tournament) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Tournament doesn't exists",
                    ],
                    404
                );
            }

            $tennisMatches = TennisMatch::where('tournament_id', $tournament->id)
            ->with(['users' => function($query) {
                $query->select('player1_user_id', 'player2_user_id');
            }])
            ->get();

            return response()->json(
                [
                    "success" => true,
                    "data" => $tennisMatches
                ],
                200
            );

        } catch (\Throwable $th) {
            Log::error('Error getting matches of tournament: ' . $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => 'Error getting matches of tournament'
                ],
                500
            );
        }
    }

    public function updateTennisMatchById(Request $request, $id){
        try {
            $tennisMatch = TennisMatch::find($id);
            if (!$tennisMatch) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Tennis match doesn't exists",
                    ],
                    404
                );
            }

            // datos de la tabla tennis_match
            $date = $request->input('date');
            $location = $request->input('location');

            if (isset($date)) {
                $tennisMatch->date = $request->input('date'); 
            }           
            if (isset($location)) {
                $tennisMatch->location = $request->input('location'); 
            }
            $tennisMatch->save();

            // datos de la tabla results para poder modificar los jugadores del partido
            $players = Result::find($id);
            $player1 = $request->input('player1_user_id');
            $player2 = $request->input('player2_user_id');
            $winnerMatch = $request->input('winner_user_id');

            if (isset($player1)) {
                $players->player1_user_id = $player1; 
            }
            if (isset($player2)) {
                $players->player2_user_id = $player2; 
            }
            if (isset($winnerMatch)) {
                $players->winner_user_id = $winnerMatch;
            }
            $players->save();

            Log::info("Tennis match updated successfully");

            return response()->json(
                [
                    "success" => true,
                    "data" => $tennisMatch, $players
                ],
                200
            );

        } catch (\Throwable $th) {
            Log::error('Error update tennis match: ' . $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => 'Error update tennis match'
                ],
                500
            );
        }
    }
}
