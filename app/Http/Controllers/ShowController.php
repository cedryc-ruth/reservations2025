<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Show;
use App\Models\Location;

class ShowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
public function index(Request $request)
{
    $query = Show::with(['location', 'representations']);

    // Recherche par titre
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Filtre par lieu
    if ($request->filled('location')) {
        $query->where('location_id', $request->location);
    }

    // Filtre par durée
    if ($request->filled('duration')) {
        $query->where('duration', '<=', $request->duration);
    }

    // Filtre par date
    if ($request->filled('date')) {
        $query->whereHas('representations', function ($q) use ($request) {
            $q->whereDate('schedule', $request->date);
        });
    }

    // Je récupère les résultats (avec ou sans filtre)
    $shows = $query->get();
    $locations = Location::all(); 

    // Je retourne la vue avec les données
    return view('show.index', compact('shows', 'locations'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Récupérer les données depuis le modèle (database)
        $show = Show::find($id);

        //Envoyer les données à la vue (template)
        return view('show.show', [
            'show' => $show,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        //
    }
}
