<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $languages = Language::with(['films'])->get();
        return response()->json($languages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
        ]);

        $language = Language::create($request->all());
        return response()->json($language, 201);
    }

    public function show(Language $language)
    {
        return response()->json($language->load(['films']));
    }

    public function update(Request $request, Language $language)
    {
        $request->validate([
            'name' => 'string|max:20',
        ]);

        $language->update($request->all());
        return response()->json($language);
    }

    public function destroy(Language $language)
    {
        $language->delete();
        return response()->json(null, 204);
    }
}
