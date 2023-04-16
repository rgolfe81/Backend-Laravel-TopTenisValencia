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
            $tournament->image = $request->input('image');
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

    public function updateTournament(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'regex:/^(?=.{1,40}$)[a-zA-Z0-9]+(?:\s[a-zA-Z0-9]+)*$/',
                'start_date' => 'date',
                'end_date' => 'date|after_or_equal:start_date',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

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

            $name = $request->input('name');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            if (isset($name)) {
                $tournament->name = $request->input('name');
            }
            if (isset($start_date)) {
                $tournament->start_date = $request->input('start_date');
            }
            if (isset($end_date)) {
                $tournament->end_date = $request->input('end_date');
            }

            $tournament->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Tournament updated",
                    "data" => $tournament
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("UPDATING TOURNAMENT: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error updating tournament"
                ],
                500
            );
        }
    }

    public function deleteTournament($id)
    {
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

            Tournament::destroy($id);
            Log::info("Delete Tournament");

            return response()->json(
                [
                    "success" => true,
                    "message" => "Tournament deleted"
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("DELETING TOURNAMENT: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting tournament"
                ],
                500
            );
        }
    }
}
