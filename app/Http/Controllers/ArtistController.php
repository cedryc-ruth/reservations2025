<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Récupérer tous les artistes (modèle - database)
        $artists = Artist::with('types')->get();

        //dd($artists);

        //Envoyer les données à la vue (template)
        return view('artist.index', [
            'artists' => $artists,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('artist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',
        ]);

        $artist = new Artist();
        $artist->firstname = $validated['firstname'];
        $artist->lastname = $validated['lastname'];

        $artist->save();

        return redirect()->route('artist.show',[$artist->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Récupérer les données depuis le modèle (database)
        $artist = Artist::find($id);

        //Envoyer les données à la vue (template)
        return view('artist.show', [
            'artist' => $artist,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //Récupérer les données depuis le modèle (database)
        $artist = Artist::find($id);

        //Envoyer les données à la vue (template)
        return view('artist.edit', [
            'artist' => $artist,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',
        ]);

        $artist = Artist::find($id);

        $artist->update($validated);

        //Envoyer les données à la vue (template)
        return view('artist.show', [
            'artist' => $artist,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $artist = Artist::find($id);

        if($artist) {
            $artist->delete();
        }

        return redirect()->route('artist.index');
    }
}
