<?php
namespace App\Http\Controllers;

use App\Models\FilmActor;
use Illuminate\Http\Request;

class FilmActorController extends Controller
{
    public function index(Request $request)
    {
        $filmActors = FilmActor::with(['actor', 'film'])->paginate($request->input('per_page', 10));
        return response()->json($filmActors);
    }

    public function store(Request $request)
    {
        $request->validate([
            'actor_id' => 'required|exists:actors,id',
            'film_id' => 'required|exists:films,id',
        ]);

        $filmActor = FilmActor::create($request->all());
        return response()->json($filmActor, 201);
    }

    public function show(FilmActor $filmActor)
    {
        return response()->json($filmActor->load(['actor', 'film']));
    }

    public function update(Request $request, FilmActor $filmActor)
    {
        $request->validate([
            'actor_id' => 'exists:actors,id',
            'film_id' => 'exists:films,id',
        ]);

        $filmActor->update($request->all());
        return response()->json($filmActor);
    }

    public function destroy(FilmActor $filmActor)
    {
        $filmActor->delete();
        return response()->json(null, 204);
    }
}
