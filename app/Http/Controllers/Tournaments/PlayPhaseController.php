<?php

namespace App\Http\Controllers\Tournaments;

use App\Http\Requests\PlayPhaseRequest;
use App\Http\Transformers\TournamentTransformer;
use ATP\Services\Tournaments\PlayPhaseService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class PlayPhaseController extends Controller {   
    /**
     * @OA\Post(
     *     path="/tournaments/{tournamentId}/play-phase",
     *     summary="Obtiene un torneo por su ID",
     *     description="Retorna los detalles de un torneo específico basado en su ID.",
     *     operationId="playPhase",
     *     tags={"Tournaments"},
     *     @OA\Parameter(
     *         name="tournamentId",
     *         in="path",
     *         description="ID del torneo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Torneo no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     */
    public function handle(PlayPhaseRequest $playPhaseRequest, PlayPhaseService $playPhaseService, TournamentTransformer $tournamentTransformer): JsonResponse {
        $tournament = $playPhaseService->excecute($playPhaseRequest);

        return response()->json([
            'data' => $tournamentTransformer->transform($tournament)
        ], JsonResponse::HTTP_CREATED);
    }
}
