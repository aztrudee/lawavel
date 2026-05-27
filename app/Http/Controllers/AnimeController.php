<?php

namespace App\Http\Controllers;

use App\Models\AnimeList;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index()
    {
        $animes = AnimeList::where('user_id', auth()->id())->latest()->get();
        return view('anime.index', compact('animes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'genre'    => 'required|string|max:100',
            'status'   => 'required|in:Watching,Completed,Plan to Watch,Dropped',
            'episodes' => 'required|integer|min:0',
            'rating'   => 'nullable|integer|min:1|max:10',
        ]);

        AnimeList::create(array_merge($request->only('title', 'genre', 'status', 'episodes', 'rating'), [
            'user_id' => auth()->id(),
        ]));

        return redirect()->route('anime.index')->with('toast_success', 'Anime added successfully!');
    }

    public function update(Request $request, AnimeList $anime)
    {
        abort_if($anime->user_id !== auth()->id(), 403);

        $request->validate([
            'title'    => 'required|string|max:255',
            'genre'    => 'required|string|max:100',
            'status'   => 'required|in:Watching,Completed,Plan to Watch,Dropped',
            'episodes' => 'required|integer|min:0',
            'rating'   => 'nullable|integer|min:1|max:10',
        ]);

        $anime->update($request->only('title', 'genre', 'status', 'episodes', 'rating'));
        return redirect()->route('anime.index')->with('toast_success', 'Anime updated successfully!');
    }

    public function destroy(AnimeList $anime)
    {
        abort_if($anime->user_id !== auth()->id(), 403);
        $anime->delete();
        return redirect()->route('anime.index')->with('toast_success', 'Anime deleted successfully!');
    }
}
