<?php

namespace App\Http\Controllers\Tournaments;

use App\Http\Transformers\TournamentTransformer;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTournamentRequest;
use ATP\Services\Tournaments\CreateTournamentService;
use Illuminate\Validation\Rule;
use ATP\Entities\Gender;
use App\Validations\ArraySize;
use App\Validations\UniqueIds;

class CreateTournamentController extends Controller {   
    /**
    * @OA\Post(
    *     path="/tournaments",
    *     summary="Crear un nuevo torneo",
    *     tags={"Tournaments"},
    * @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"name", "gender"},
    *             @OA\Property(property="name", type="string", example="Torneo de verano"),
    *             @OA\Property(property="gender", type="string", example="female|male"),
    *             @OA\Property(
    *                 property="players",
    *                 type="array",
    *                 @OA\Items(type="integer", example=1),
    *                 description="Array de IDs de usuarios"
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Crear torneo"
    *     )
    * )
    */
    public function handle(
        CreateTournamentRequest $createTournamentRequest, 
        CreateTournamentService $createTournamentService,
        TournamentTransformer $tournamentTransformer
    ): JsonResponse {
        $validator = $this->validator->make($createTournamentRequest->request()->all(), [
            CreateTournamentRequest::NAME => 'required|string|max:255',
            CreateTournamentRequest::GENDER => ['required', Rule::in(Gender::cases())],
            CreateTournamentRequest::PLAYERS =>  [
                'required', 'array', new ArraySize([2, 4, 8]), new UniqueIds
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'=> $validator->errors(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
        
        $tournament = $createTournamentService->excecute($createTournamentRequest);
        
        return response()->json([
            'success' => true, 
            'data' => $tournamentTransformer->transform($tournament)
        ], JsonResponse::HTTP_CREATED);
    }
}
    