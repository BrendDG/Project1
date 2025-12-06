<?php

namespace App\Http\Controllers;

use App\Models\Nieuws;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $nieuws = Nieuws::with(['comments' => function($query) {
            $query->with('user')->latest();
        }])
        ->where('id', $id)
        ->where('published_at', '<=', now())
        ->firstOrFail();

        return view('nieuws.show', compact('nieuws'));
    }

    /**
     * Store a new comment
     */
    public function storeComment(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Je moet ingelogd zijn om een comment te plaatsen.');
        }

        $nieuws = Nieuws::where('id', $id)
            ->where('published_at', '<=', now())
            ->firstOrFail();

        $validated = $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        Comment::create([
            'nieuws_id' => $nieuws->id,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        return redirect()->route('nieuws.show', $nieuws->id)->with('success', 'Comment succesvol geplaatst!');
    }

    /**
     * Delete a comment
     */
    public function destroyComment($nieuwsId, $commentId)
    {
        $comment = Comment::where('id', $commentId)
            ->where('nieuws_id', $nieuwsId)
            ->firstOrFail();

        // Only allow user to delete their own comment, or admin to delete any comment
        if (Auth::id() !== $comment->user_id && !Auth::user()->is_admin) {
            return back()->with('error', 'Je kunt alleen je eigen comments verwijderen.');
        }

        $comment->delete();

        return back()->with('success', 'Comment succesvol verwijderd!');
    }
}
