<?php

namespace App\Http\Controllers\Tournaments;

use App\Http\Transformers\TournamentTransformer;
use ATP\Repositories\Filters\TournamentFilter;
use ATP\Repositories\TournamentRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="ATP2",
 *     version="1.0.0",
 *     description="Documentación de sistem de ATP"
 * )
 */
class ListTournamentController extends Controller {   
    /**
     * @OA\Get(
     *     path="/tournaments",
     *     summary="Obtiene una lista de torneos",
     *     description="Retorna una lista de torneos con opciones de filtrado, paginación y ordenación.",
     *     operationId="listTournaments",
     *     tags={"Tournaments"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filtrar torneos por nombre",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número de página para la paginación",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Número de elementos por página",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="sortBy",
     *         in="query",
     *         description="Campo por el cual ordenar los resultados",
     *         required=false,
     *         @OA\Schema(type="string", default="id")
     *     ),
     *     @OA\Parameter(
     *         name="sortOrder",
     *         in="query",
     *         description="Orden de clasificación (asc o desc)",
     *         required=false,
     *         @OA\Schema(type="string", default="desc")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de torneos obtenida exitosamente",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Parámetros de solicitud inválidos"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     */
    public function handle(Request $request, TournamentRepository $tournamentRepository, TournamentTransformer $tournamentTransformer): JsonResponse {
        $filter = new TournamentFilter($request->query());
        $paginate = $this->paginate($request);

        $tournaments = $tournamentRepository->filter($filter, $paginate);
        
        return response()->json([
            'data' => $tournamentTransformer->map($tournaments)
        ], JsonResponse::HTTP_CREATED);
    }
}
