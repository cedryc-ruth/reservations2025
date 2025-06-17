<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Doctrine\DBAL\Types\TypeRegistry;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all();

        return view('type.index',[
            'types' => $types,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|max:60',
        ]);
        $type = new Type();
        $type->$validated['type'];
        $type->save();
        return redirect()->route('type.show',[$type->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $type = Type::find($id);

        return view('type.show',[
            'type' => $type,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $type = Type::find($id);

        //Envoyer les données à la vue (template)
        return view('type.edit', [
            'type' => $type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'type' => 'required|max:60',
        ]);

        $type = Type::find($id);

        $type->update($validated);

        
        //Envoyer les données à la vue (template)
        return view('type.show', [
            'type' => $type,
        ]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $type = Type::find($id);

        if($type) {
            $type->delete();
        }

        return redirect()->route('type.index');
    }
}
