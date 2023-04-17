<?php

namespace App\Http\Controllers;

use App\Models\TennisMatch;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TennisMatchController extends Controller
{
    public function createMatchToTournamentId(Request $request, $id)
    {
        try {
            $userIds = $request->input('user_ids');
            $tournament = Tournament::find($id); 

            if (!$tournament) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Tournament 404 not found"
                    ],
                    404
                );
            }

            $tournamentUsers = $tournament->users()->pluck('users.id')->toArray();

            // Verificar que los ids de usuario estén inscritos en el torneo seleccionado
            $missingIds = array_diff($userIds, $tournamentUsers);
            if ($missingIds) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User(s) not registered at selected tournament"
                    ],
                    403
                );
            }

            $tennisMatch = new TennisMatch();
            $tennisMatch->tournament_id = $id; //$id es tournament_id pasado por parametros del controlador
            $tennisMatch->save();
            $tennisMatch->users()->attach($userIds);

            $tennisMatch->users;
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

    public function getMatchesbyTournamentId($id){
        try {
            $tournament = Tournament::find($id);
            if (!$tournament) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Tournament doesn't exists",
                    ],
                    404
                );
            }
            $tennisMatches = TennisMatch::where('tournament_id', $tournament->id)->with('users')->get();

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
}
