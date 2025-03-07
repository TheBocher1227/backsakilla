<?php

namespace App\Http\Controllers;

use App\Models\FilmCategory;
use Illuminate\Http\Request;

class FilmCategoryController extends Controller
{
    public function index(Request $request)
    {
        $filmCategories = FilmCategory::with(['film', 'category'])->get();
        return response()->json($filmCategories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'film_id' => 'required|exists:films,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $filmCategory = FilmCategory::create($request->all());
        return response()->json($filmCategory, 201);
    }

    public function show(FilmCategory $filmCategory)
    {
        return response()->json($filmCategory->load(['film', 'category']));
    }

    public function update(Request $request, FilmCategory $filmCategory)
    {
        $request->validate([
            'film_id' => 'exists:films,id',
            'category_id' => 'exists:categories,id',
        ]);

        $filmCategory->update($request->all());
        return response()->json($filmCategory);
    }

    public function destroy(FilmCategory $filmCategory)
    {
        $filmCategory->delete();
        return response()->json(null, 204);
    }
}
