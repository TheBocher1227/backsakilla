<?php
namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ActorController extends Controller
{
    public function __construct()
    {
        Route::bind('actor', function ($value) {
            return Actor::where('actor_id', $value)->firstOrFail();
        });
    }

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

        $data = $request->all();
        $data['status'] = true;
        $actor = Actor::create($data);
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
        $actor->update(['status' => false]);
        return response()->json(['message' => 'Actor desactivado correctamente'], 200);
    }
}
