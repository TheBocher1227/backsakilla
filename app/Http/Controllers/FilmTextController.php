<?php
namespace App\Http\Controllers;

use App\Models\FilmText;
use Illuminate\Http\Request;

class FilmTextController extends Controller
{
    public function index(Request $request)
    {
        $filmTexts = FilmText::with(['film'])->get();
        return response()->json($filmTexts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'film_id' => 'required|exists:films,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $filmText = FilmText::create($request->all());
        return response()->json($filmText, 201);
    }

    public function show(FilmText $filmText)
    {
        return response()->json($filmText->load(['film']));
    }

    public function update(Request $request, FilmText $filmText)
    {
        $request->validate([
            'film_id' => 'exists:films,id',
            'title' => 'string|max:255',
            'description' => 'nullable|string',
        ]);

        $filmText->update($request->all());
        return response()->json($filmText);
    }

    public function destroy(FilmText $filmText)
    {
        $filmText->delete();
        return response()->json(null, 204);
    }
}
