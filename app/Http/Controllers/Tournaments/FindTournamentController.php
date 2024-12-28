<?php

namespace App\Http\Controllers\Tournaments;

use App\Http\Controllers\Controller;
use App\Http\Transformers\TournamentTransformer;
use ATP\Repositories\TournamentRepository;
use Illuminate\Http\JsonResponse;

class FindTournamentController extends Controller {   
    /**
     * @OA\Get(
     *     path="/tournaments/{id}",
     *     summary="Obtiene un torneo por su ID",
     *     description="Retorna los detalles de un torneo específico basado en su ID.",
     *     operationId="getTournamentById",
     *     tags={"Tournaments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del torneo a buscar",
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
    