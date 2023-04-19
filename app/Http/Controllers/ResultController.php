<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\TennisMatch;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResultController extends Controller
{
    public function addResultbyTennisMatchId(Request $request, $tennis_match_id){
        try {
            // dd($request->input('set_number'));
            $tennis_match = TennisMatch::find($tennis_match_id);
            $user = Auth::user();

            if (!$tennis_match) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Tennis match doesn't exists",
                    ],
                    404
                );
            }

            // if (!$tennis_match->users->contains($player1_id) || !$tennis_match->users->contains($player2_id)){
            //     return response()->json(
            //         [
            //             "success" => true,
            //             "message" => "Users selected not participate in this tennis match",
            //         ],
            //         403
            //     );
            // }
                
            $result = new Result();
            $result->tennis_match_id = $tennis_match_id;
            $result->user_id = $player1_id;
            // $result->set_number = $request->input('set_number');
            // $result->score = $request->input('score');
            // $result->winner = $request->input('winner');
            $result->save();

            $result2 = new Result();
            $result2->tennis_match_id = $tennis_match_id;
            $result2->user_id = $player2_id;
            // $result2->set_number = $request->input('set_number');
            // $result2->score = $request->input('score');
            // $result2->winner = $request->input('winner');
            $result2->save();

            // $date = $request->input('date');
            // $location = $request->input('location');
            // $result->matches()->attach($date);
            // $result->matches()->attach($location);

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
}
