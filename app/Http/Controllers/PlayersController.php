<?php

namespace App\Http\Controllers;

use App\Models\Players;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Players $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $playerequest, Players $player)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Players $player)
    {
        //
    }
}
