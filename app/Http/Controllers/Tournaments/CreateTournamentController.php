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
    