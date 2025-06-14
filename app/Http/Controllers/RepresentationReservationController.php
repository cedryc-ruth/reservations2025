<?php

namespace App\Http\Controllers;

use App\Models\RepresentationReservation;
use Illuminate\Http\Request;

class RepresentationReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries = RepresentationReservation::with([
            'reservation.user',
            'representation.show',
            'price'
        ])->get();

        return view('representation_reservation.index', [
            'entries' => $entries,
        ]);
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
        $entry = RepresentationReservation::with([
            'reservation.user',
            'representation.show',
            'price'
        ])->findOrFail($id);

        return view('representation_reservation.show', [
            'entry' => $entry,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepresentationReservation $representationReservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RepresentationReservation $representationReservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepresentationReservation $representationReservation)
    {
        //
    }
}
