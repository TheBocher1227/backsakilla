<?php
namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::with(['country'])->get();
        return response()->json($cities);
    }

    public function store(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:50',
            'country_id' => 'required|exists:countries,id',
        ]);

        $city = City::create($request->all());
        return response()->json($city, 201);
    }

    public function show(City $city)
    {
        return response()->json($city->load(['country']));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'city' => 'string|max:50',
            'country_id' => 'exists:countries,id',
        ]);

        $city->update($request->all());
        return response()->json($city);
    }

    public function destroy(City $city)
    {
        $city->delete();
        return response()->json(null, 204);
    }
}
