<?php

namespace App\Http\Controllers;

use App\Models\Players;
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
        $user = Auth::user(); // Ensure user is authenticated

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
}
