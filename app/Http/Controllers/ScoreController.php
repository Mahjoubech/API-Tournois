<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\Matches;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ScoreController extends Controller
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
             $scores = Score::with(['match', 'playerOne', 'playerTwo'])->get();
            if ($scores->isEmpty()) {
            return response()->json(['message' => 'No scores found'], 404);
        }
    
        $formattedScores = $scores->map(function ($score) {
            return [
                'match_id' => $score->match->id,  
                'score' => "{$score->playerOne->name} {$score->player1_score} - {$score->player2_score} {$score->playerTwo->name}"
            ];
        });
    
        return response()->json($formattedScores);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'player1_id' => 'required|exists:players,id',
            'player2_id' => 'required|exists:players,id',
            'match_id' => 'required|exists:matches,id',
            'player1_score' => 'required|integer',
            'player2_score' => 'required|integer',
        ]);
        if (!$request->user()) {
            return response()->json(['message' => 'Utilisateur non authentifié'], 401);
        }
        $score = Score::create([
            'player1_id' => $request->player1_id,
            'player2_id' => $request->player2_id,
            'match_id' => $request->match_id,
            'player1_score' => $request->player1_score,
            'player2_score' => $request->player2_score,
            'user_id' => $request->user()->id
        ]);
        return response()->json($score, 201);

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $score = Score::find($id);
        if (!$score) {
            return response()->json(['message' => 'Score not found'], 404);
        }
        Gate::authorize('modify', $score);
        $data = $request->validate([
            'player1_id' => 'required|exists:players,id',
            'player2_id' => 'required|exists:players,id',
            'match_id' => 'required|exists:matches,id',
            'player1_score' => 'required|integer',
            'player2_score' => 'required|integer',
        ]);
        $score->update($data);
        return response()->json($score);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $score = Score::find($id);
        if (!$score) {
            return response()->json(['message' => 'Score not found'], 404);
        }
        Gate::authorize('modify', $score);
        $score->delete();
        return response()->json(['message' => 'The Score was deleted']);
    }
}
