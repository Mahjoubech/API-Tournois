<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\Matches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index()
    {
        return response()->json(Players::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|integer',
            'tournois_id' => 'required|exists:tournois,id',
        ]);
        $user = Auth::user(); 

    if (!$user) {
        return response()->json(['message' => 'Utilisateur non authentifié'], 401);
    }

    $player = Players::create([
        'name' => $request->name,
        'number' => $request->number,
        'user_id' => $user->id, // Use authenticated user's ID
        'tournois_id' => $request->tournois_id
    ]);
    return response()->json($player, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Players $player)
    {
        if (!$player) {
            return response()->json(['message' => 'Tournoi non trouvé'], 404);
        }

        return response()->json($player);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $player = Players::find($id);
        if (!$player) {
            return response()->json(['message' => 'Player not found'], 404);
        }
        Gate::authorize('modify', $player);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|integer',
        ]);
        $player->update($data);
        return response()->json($player);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $player =Players::find($id);
        if (!$player) {
            return response()->json(['message' => 'Player not found'], 404);
        }
        Gate::authorize(('modify'), $player);
        $player->delete();
        return response()->json(['message' => 'The Player was deleted']);
    }

    public function assignToMatch(Request $request, $player_id)
{
    $player = Players::find($player_id);
    if (!$player) {
        return response()->json(['message' => 'Player not found'], 404);
    }

    $request->validate([
        'match_id' => 'required|exists:matches,id'
    ]);

    $match = Matches::find($request->match_id);
    if (!$match) {
        return response()->json(['message' => 'Match not found'], 404);
    }
    if ($match->players()->count() >= 2) {
        return response()->json(['message' => 'Match already has 2 players'], 400);
    }
    if (!$player->matches()->where('match_player.match_id', $request->match_id)->exists()) {
        $player->matches()->attach($request->match_id);
        return response()->json(['message' => 'Player assigned to match successfully']);
    }
    

    return response()->json(['message' => 'Player already assigned to this match'], 400);
}
public function removeFromMatch($player_id, $match_id)
{
    $player = Players::find($player_id);
    $match = Matches::find($match_id);

    if (!$player || !$match) {
        return response()->json(['message' => 'Player or Match not found'], 404);
    }

    // Detach the player from the match
    $player->matches()->detach($match_id);

    return response()->json(['message' => 'Player removed from match successfully']);
}
public function getPlayerMatches($player_id)
{
    $player = Players::find($player_id);
    if (!$player) {
        return response()->json(['message' => 'Player not found'], 404);
    }

    return response()->json($player->matches);
}

}
