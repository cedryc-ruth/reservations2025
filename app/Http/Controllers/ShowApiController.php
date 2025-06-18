<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Show;

class ShowApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Show::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|max:60',
            'title' => 'required|string|max:255',
            'poster_url'=> 'required|string|max:255',
            'duration'=>'required|smallint',
            'created_in'=>'year',
            'location_id'=>'foreignId',
            'bookable'=>'boolean',
        ]);

        $show = Show::create($validated);

        return response()->json($show, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = Show::find($id);

        if (!$show) {
            return response()->json(['message' => 'Show not found'], 404);
        }

        return response()->json($show, 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $show = Show::find($id);

        if (!$show) {
            return response()->json(['message' => 'Show not found'], 404);
        }

        $show->delete();

        return response()->json(['message' => 'Show deleted'], 200);

    }
}
