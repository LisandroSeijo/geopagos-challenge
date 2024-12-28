<?php

namespace App\Http\Controllers\Tournaments;

use App\Http\Requests\PlayPhaseRequest;
use App\Http\Transformers\TournamentTransformer;
use ATP\Services\Tournaments\PlayPhaseService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class PlayPhaseController extends Controller {   
    public function handle(PlayPhaseRequest $playPhaseRequest, PlayPhaseService $playPhaseService, TournamentTransformer $tournamentTransformer): JsonResponse {
        $tournament = $playPhaseService->excecute($playPhaseRequest);

        return response()->json([
            'data' => $tournamentTransformer->transform($tournament)
        ], JsonResponse::HTTP_CREATED);
    }
}
