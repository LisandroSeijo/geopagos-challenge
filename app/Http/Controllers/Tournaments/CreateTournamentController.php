<?php

namespace App\Http\Controllers\Tournaments;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTournamentRequest;
use ATP\Services\Tournaments\CreateTournamentService;
use Illuminate\Validation\Rule;
use ATP\Entities\Gender;

class CreateTournamentController extends Controller {   
    public function handle(
        CreateTournamentRequest $createTournamentRequest, 
        CreateTournamentService $createTournamentService
    ): JsonResponse {
        $validator = $this->validator->make($createTournamentRequest->request()->all(), [
            'name' => 'required|string|max:255',
            'gender' => ['required', Rule::in(Gender::cases())]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'=> $validator->errors(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
        
        $createTournamentService->excecute($createTournamentRequest);
        
        return response()->json(['success' => true], JsonResponse::HTTP_CREATED);
    }
}
    