<?php

namespace App\Http\Controllers\Tournaments;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTournamentRequest;
use ATP\Services\Tournaments\CreateTournamentService;

class CreateTournamentController extends Controller {   
    public function handle(
        CreateTournamentRequest $createTournamentRequest, 
        CreateTournamentService $createTournamentService
    ): JsonResponse {
        $validator = $this->validator->make($createTournamentRequest->request()->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false]);
        }
        
        $createTournamentService->excecute($createTournamentRequest);
        
        return response()->json(['success' => true], JsonResponse::HTTP_CREATED);
    }
}
    