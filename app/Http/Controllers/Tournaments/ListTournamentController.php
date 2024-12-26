<?php

namespace App\Http\Controllers\Tournaments;

use App\Http\Transformers\TournamentTransformer;
use ATP\Repositories\Filters\TournamentFilter;
use ATP\Repositories\TournamentRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListTournamentController extends Controller {   
    public function handle(Request $request, TournamentRepository $tournamentRepository, TournamentTransformer $tournamentTransformer): JsonResponse {
        $filter = new TournamentFilter($request->query());
        $paginate = $this->paginate($request);

        $tournaments = $tournamentRepository->filter($filter, $paginate);
        
        return response()->json([
            'data' => $tournamentTransformer->map($tournaments)
        ], JsonResponse::HTTP_CREATED);
    }
}
