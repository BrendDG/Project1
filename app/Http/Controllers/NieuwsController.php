<?php

namespace App\Http\Controllers;

use App\Models\Nieuws;
use Illuminate\Http\Request;

class NieuwsController extends Controller
{
    /**
     * Display a listing of the news items.
     */
    public function index()
    {
        $nieuws = Nieuws::published()->paginate(10);

        return view('nieuws.index', compact('nieuws'));
    }

    /**
     * Display the specified news item.
     */
    public function show($id)
    {
        $nieuws = Nieuws::where('id', $id)
            ->where('published_at', '<=', now())
            ->firstOrFail();

        return view('nieuws.show', compact('nieuws'));
    }
}
