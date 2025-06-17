<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Show;
use Illuminate\Http\Request;


class ReviewController extends Controller
{
    public function index(Show $show)
    {
        $show->load(['reviews.user']);
        return view('reviews.index', ['show' => $show]);
    }
}
