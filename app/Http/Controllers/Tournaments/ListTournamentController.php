<?php

namespace App\Http\Controllers\Tournaments;

use ATP\Repositories\Filters\TournamentFilter;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListTournamentController extends Controller {   
    public function handle(Request $request): JsonResponse {
        $filter = new TournamentFilter($request->query());
        
        return response()->json(['success' => true], JsonResponse::HTTP_CREATED);
    }
}
