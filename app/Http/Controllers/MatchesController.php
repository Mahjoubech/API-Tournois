<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Matches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
class MatchesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Matches::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date_match' => 'required|date',
            'tournois_id' => 'required|exists:tournois,id',
        ]);
        if (!$request->user()) {
            return response()->json(['message' => 'Utilisateur non authentifié'], 401);
        }
        $match = Matches::create([
            'date_match' => $request->date_match,
            'tournois_id' => $request->tournois_id,
            'user_id' => $request->user()->id
                ]);
        return response()->json($match, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Matches $matches)
    {
        if (!$matches) {
            return response()->json(['message' => 'Match not found'], 404);
        }
        return response()->json($matches);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $match = Matches::find($id);
        if (!$match) {
            return response()->json(['message' => 'Match not found'], 404);
        }
        Gate::authorize('modify', $match);
        $data = $request->validate([
            'match_date' => 'required|date',
            'tournois_id' => 'required|exists:tournois,id',
        ]);
        $match->update($data);
        return response()->json($match);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $match = Matches::find($id);
        if (!$match) {
            return response()->json(['message' => 'Match not found'], 404);
        }
        Gate::authorize('modify', $match);
        $match->delete();
        return response()->json(['message' => 'The Match was deleted']);
    }
    public function getMatchPlayers($match_id)
{
    $match = Matches::find($match_id);
    if (!$match) {
        return response()->json(['message' => 'Match not found'], 404);
    }

    return response()->json($match->players);
}

}
