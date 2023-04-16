<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function createTournament(Request $request)
    {
        try {
            Log::info("Create Tournament");

            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^(?=.{1,40}$)[a-zA-Z0-9]+(?:\s[a-zA-Z0-9]+)*$/',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $tournament = new Tournament();
            $tournament->name = $request->input('name');
            $tournament->start_date = $request->input('start_date');
            $tournament->end_date = $request->input('end_date');
            $tournament->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Tournament created",
                    "data" => $tournament
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("CREATING TOURNAMENT: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating tournament"
                ],
                500
            );
        }
    }

}
