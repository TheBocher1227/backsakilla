<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::with(['cities'])->get();
        return response()->json($countries);
    }

    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:50',
        ]);

        $country = Country::create($request->all());
        return response()->json($country, 201);
    }

    public function show(Country $country)
    {
        return response()->json($country->load(['cities']));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'country' => 'string|max:50',
        ]);

        $country->update($request->all());
        return response()->json($country);
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return response()->json(null, 204);
    }
}
