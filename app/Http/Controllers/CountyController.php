<?php

namespace App\Http\Controllers;

use App\Models\County;
use Illuminate\Http\Request;

class CountyController extends Controller
{
/**
 * @api {get} /counties Megyék listázása
 * @apiName GetCounties
 * @apiGroup Counties
 * @apiQuery {String} [search] Keresés megye nevére
 * @apiSuccess {Object[]} data Megyék listája
 */
    public function index(Request $request)
    {
        $query = County::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return response()->json($query->orderBy('name')->get());
    }

/**
 * @api {post} /counties Új megye létrehozása
 * @apiName CreateCounty
 * @apiGroup Counties
 * @apiHeader {String} Authorization Bearer {token}
 * @apiBody {String} name Megye neve
 * @apiSuccess {Number} id Létrehozott megye azonosítója
 * @apiSuccess {String} name Megye neve
 */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:counties,name',
        ]);

        $county = County::create($validated);
        return response()->json($county, 201);
    }

/**
 * @api {get} /counties/:id Egy megye lekérdezése
 * @apiName GetCounty
 * @apiGroup Counties
 * @apiParam {Number} id Megye egyedi azonosítója
 * @apiSuccess {Number} id Megye azonosító
 * @apiSuccess {String} name Megye neve
 */
    public function show(string $id)
    {
        $county = County::with('cities')->findOrFail($id);
        return response()->json($county);
    }

/**
 * @api {put} /counties/:id Megye módosítása
 * @apiName UpdateCounty
 * @apiGroup Counties
 * @apiHeader {String} Authorization Bearer {token}
 * @apiParam {Number} id Megye azonosítója
 * @apiBody {String} name Megye új neve
 */
    public function update(Request $request, string $id)
    {
        $county = County::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:counties,name,' . $county->id,
        ]);

        $county->update($validated);
        return response()->json($county);
    }

/**
 * @api {delete} /counties/:id Megye törlése
 * @apiName DeleteCounty
 * @apiGroup Counties
 * @apiHeader {String} Authorization Bearer {token}
 * @apiParam {Number} id Megye azonosítója
 */
    public function destroy(string $id)
    {
        $county = County::findOrFail($id);
        $county->delete();

        return response()->json(['message' => 'County deleted']);
    }
}