<?php

namespace App\Http\Controllers;

use App\Models\Tournois;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OpenApi\Annotations as OA;

class TournoisController extends Controller
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
        return response()->json(    Tournois::with('user')->get());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $trn = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    if (!$request->user()) {
        return response()->json(['message' => 'Utilisateur non authentifié'], 401);
    }

    $trnois = $request->user()->tournois()->create($trn);

    return response()->json(['tournois' => $trnois , 'user' =>$request->user()], 201);
}


    /**
     * Display the specified resource.
     */
    public function show(Tournois $tournois)
    {

        if (!$tournois) {
            return response()->json(['message' => 'Tournoi non trouvé'], 404);
        }

        return response()->json($tournois);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
            $tournois = Tournois::find($id);
            Gate::authorize('modify', $tournois);
            if (!$tournois) {
                return response()->json(['message' => 'Tournoi non trouvé'], 404);
            }
            $data = $request->validate([
             'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);
            $tournois->update($data);
            return response()->json($tournois);
        }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tournois = Tournois::find($id);

        Gate::authorize('modify', $tournois);
        $tournois->delete();
        return ['message' => 'The Tournois was deleted'];
    }
}
