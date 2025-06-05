<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Show;
use App\Models\Tag;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function index(Request $request)
    {
        $tagQuery = $request->input('tag');

        if ($tagQuery) {
            $shows = Show::whereHas('tags', function ($query) use ($tagQuery) {
                $query->where('tag', 'LIKE', '%' . $tagQuery . '%');
            })->get();
        } else {
            $shows = Show::all();
        }

        return view('shows.index', compact('shows', 'tagQuery'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = Show::with('tags', 'location.locality')->findOrFail($id);
        return view('shows.show', compact('show'));
    }

    public function addTags(Request $request, $id)
    {
        $show = Show::findOrFail($id);

        // Vérifie si l’utilisateur est admin
        // if (auth()->user()->role !== 'admin') {
        //     abort(403, 'Accès réservé');
        // }

        $inputTags = explode(',', $request->input('tags'));

        foreach ($inputTags as $rawTag) {
            $tagName = trim($rawTag);

            // On cherche ou crée le tag
            $tag = Tag::firstOrCreate(['tag' => $tagName]);

            // Associer au spectacle (sans doublon)
            $show->tags()->syncWithoutDetaching([$tag->id]);
        }

    return redirect()->route('shows.show', $show->id)
        ->with('success', 'Mots-clés ajoutés avec succès.');
    }

    public function create()
    {
    $locations = Location::all();
    return view('shows.create', compact('locations'));
    }

    public function withoutTag($tag)
    {
        $shows = Show::whereDoesntHave('tags', function ($query) use ($tag) {
            $query->where('tag', 'LIKE', '%' . $tag . '%');
        })->get();

        return view('shows.without-tag', compact('shows', 'tag'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'slug' => 'required|unique:shows,slug|max:100',
            'poster_url' => 'nullable|url',
            'duration' => 'required|integer|min:1',
            'created_in' => 'required|integer|min:1900|max:' . date('Y'),
            'location_id' => 'required|exists:locations,id',
            'bookable' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        // Correction de bookable (case à cocher)
        $validated['bookable'] = $request->has('bookable');

        Show::create($validated);

        return redirect()->route('shows.index')->with('success', 'Spectacle ajouté avec succès.');
    }
}