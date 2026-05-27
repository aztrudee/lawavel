<?php

namespace App\Http\Controllers;

use App\Models\AnimeList;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers  = User::count();
        $totalAnime  = AnimeList::where('user_id', auth()->id())->count();

        $statusCounts = AnimeList::where('user_id', auth()->id())
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $genreCounts = AnimeList::where('user_id', auth()->id())
            ->selectRaw('genre, count(*) as count')
            ->groupBy('genre')
            ->pluck('count', 'genre');

        return view('dashboard', compact('totalUsers', 'totalAnime', 'statusCounts', 'genreCounts'));
    }
}
