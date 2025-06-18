<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Show $show)
    {
        $show->load(['reviews.user']);
        return view('reviews.index', ['show' => $show]);
    }


    public function store(Request $request)
{
    $validated = $request->validate([
        'show_id' => 'required|exists:shows,id',
        'review' => 'required|string',
        'stars' => 'required|integer|min:1|max:5',
    ]);

    Review::create([
        'user_id' => Auth::id(),
        'show_id' => $validated['show_id'],
        'review' => $validated['review'],
        'stars' => $validated['stars'],
    ]);

    return redirect()->back()->with('success', 'Merci pour votre commentaire !');
}
}
