<?php

namespace App\Http\Controllers\Tournaments;

use App\Http\Controllers\Controller;
use App\Http\Transformers\TournamentTransformer;
use ATP\Repositories\TournamentRepository;
use Illuminate\Http\JsonResponse;

class FindTournamentController extends Controller {   
    public function handle(int $id, TournamentRepository $tournamentRepository, TournamentTransformer $tournamentTransformer): JsonResponse {
        $tournament = $tournamentRepository->findById($id);
        
        if (!$tournament) {
            return response()->json(['success' => false], JsonResponse::HTTP_BAD_REQUEST);
        }
        
        return response()->json([
            'tournament' => $tournamentTransformer->transform($tournament)
        ], JsonResponse::HTTP_OK);
    }
}
    