<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use Illuminate\Support\Facades\Log;

class ClassificationController extends Controller
{
    public function getClassificationByTournamentId($tournament_id){
        try {
            $classification = Classification::where('tournament_id', $tournament_id)
            ->orderBy('score', 'desc')
            ->get();

            return response()->json(
                [
                    "success" => true,
                    "data" => $classification
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("GETTING CLASSIFICATION BY TOURNAMENT: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting classification by tournament"
                ],
                500
            );
        }
    }
}
