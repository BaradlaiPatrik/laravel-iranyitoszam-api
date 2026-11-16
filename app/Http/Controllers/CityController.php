<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
/**
 * @api {delete} /counties/:id Megye törlése
 * @apiName DeleteCounty
 * @apiGroup Counties
 * @apiHeader {String} Authorization Bearer {token}
 * @apiParam {Number} id Megye azonosítója
 */
    public function index(Request $request)
    {
        $query = City::with('county');

        if ($request->filled('county_id')) {
            $query->where('county_id', $request->county_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('zip', 'like', "%{$search}%");
            });
        }

        return response()->json($query->orderBy('zip')->get());
    }

/**
 * @api {post} /cities Új település létrehozása
 * @apiName CreateCity
 * @apiGroup Cities
 * @apiHeader {String} Authorization Bearer {token}
 * @apiBody {String} zip Irányítószám
 * @apiBody {String} name Település neve
 * @apiBody {Number} county_id Megye azonosítója
 */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'zip' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'county_id' => 'required|exists:counties,id',
        ]);

        $city = City::create($validated);
        return response()->json($city->load('county'), 201);
    }

/**
 * @api {get} /cities/:id Egy település lekérdezése
 * @apiName GetCity
 * @apiGroup Cities
 * @apiParam {Number} id Település azonosítója
 */
    public function show(string $id)
    {
        $city = City::with('county')->findOrFail($id);
        return response()->json($city);
    }
/**
 * @api {put} /cities/:id Település módosítása
 * @apiName UpdateCity
 * @apiGroup Cities
 * @apiHeader {String} Authorization Bearer {token}
 * @apiParam {Number} id Település azonosítója
 * @apiBody {String} zip Irányítószám
 * @apiBody {String} name Település neve
 * @apiBody {Number} county_id Megye azonosítója
 */
    public function update(Request $request, string $id)
    {
        $city = City::findOrFail($id);

        $validated = $request->validate([
            'zip' => 'sometimes|required|string|max:10',
            'name' => 'sometimes|required|string|max:255',
            'county_id' => 'sometimes|required|exists:counties,id',
        ]);

        $city->update($validated);
        return response()->json($city->load('county'));
    }

/**
 * @api {delete} /cities/:id Település törlése
 * @apiName DeleteCity
 * @apiGroup Cities
 * @apiHeader {String} Authorization Bearer {token}
 * @apiParam {Number} id Település azonosítója
 */
    public function destroy(string $id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json(['message' => 'City deleted']);
    }
}