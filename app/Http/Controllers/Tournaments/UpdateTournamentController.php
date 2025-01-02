<?php

namespace App\Http\Controllers\Tournaments;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTournamentRequest;
use ATP\Services\Tournaments\UpdateTournamentService;

class UpdateTournamentController extends Controller {   
    /**
    * @OA\Put(
    *     path="/tournaments/{id}",
    *     summary="Actualiza un nuevo torneo",
    *     tags={"Tournaments"},
    *     operationId="updateTournament",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID del torneo",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    * @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"name"},
    *             @OA\Property(property="name", type="string", example="Torneo de verano"),
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Crear torneo"
    *     )
    * )
    */
    public function handle(
        int $id,
        UpdateTournamentRequest $updateTournamentRequest, 
        UpdateTournamentService $updateTournamentService
    ): JsonResponse {
        try {
        $validator = $this->validator->make($updateTournamentRequest->request()->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
        
        $updateTournamentService->excecute($id, $updateTournamentRequest);
        
        return response()->json(['success' => true], JsonResponse::HTTP_CREATED);
        } catch(\Exception $ex) { die($ex->getMessage()); }
    }
}
    