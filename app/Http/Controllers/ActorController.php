<?php
namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    public function index(Request $request)
    {
        $actors = Actor::with(['films'])->get();
        return response()->json($actors);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
        ]);

        $actor = Actor::create($request->all());
        return response()->json($actor, 201);
    }

    public function show(Actor $actor)
    {
        return response()->json($actor->load(['films']));
    }

    public function update(Request $request, Actor $actor)
    {
        $request->validate([
            'first_name' => 'string|max:45',
            'last_name' => 'string|max:45',
        ]);

        $actor->update($request->all());
        return response()->json($actor);
    }

    public function destroy(Actor $actor)
    {
        $actor->delete();
        return response()->json(null, 204);
    }
}
