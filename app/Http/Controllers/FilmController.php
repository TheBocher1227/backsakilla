<?php
namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use App\Http\Controllers\Respone;
class FilmController extends Controller
{
    public function index(Request $request)
    {
        $films = Film::with(['language', 'actors', 'categories'])->get();
        return response()->json($films);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'required|integer',
            'language_id' => 'required|exists:language,language_id',
            'rental_duration' => 'required|integer',
            'rental_rate' => 'required|numeric',
            'length' => 'required|integer',
            'replacement_cost' => 'required|numeric',
            'rating' => 'required|string',
            'special_features' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['status'] = true;
        $film = Film::create($data);
        return response()->json($film, 201);
    }

    public function show(Film $film)
    {
        return response()->json($film->load(['language', 'actors', 'categories']));
    }

    public function update(Request $request, Film $film)
    {
        $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'integer',
            'language_id' => 'exists:language,language_id',
            'rental_duration' => 'integer',
            'rental_rate' => 'numeric',
            'length' => 'integer',
            'replacement_cost' => 'numeric',
            'rating' => 'string',
            'special_features' => 'nullable|string',
        ]);

        $film->update($request->all());
        return response()->json($film);
    }

    public function destroy(Film $film)
    {
        $film->update(['status' => false]);
        return response()->json(['message' => 'Película desactivada correctamente'], 200);
    }
}
