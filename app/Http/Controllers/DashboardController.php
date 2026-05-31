<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    public function index() {
        $uid = auth()->id();

        $stats = Anime::where('user_id', $uid)->selectRaw("
            COUNT(*) as total,
            SUM(status='watching')      as watching,
            SUM(status='completed')     as completed,
            SUM(status='plan_to_watch') as planned,
            SUM(status='dropped')       as dropped,
            COALESCE(SUM(episodes_watched), 0) as total_eps
        ")->first();

        $genreRows   = Anime::where('user_id', $uid)
            ->whereNotNull('genre')
            ->selectRaw('genre, COUNT(*) as cnt')
            ->groupBy('genre')->orderByDesc('cnt')
            ->limit(6)->get();

        $nowWatching = Anime::where('user_id', $uid)
            ->where('status', 'watching')
            ->orderByDesc('updated_at')
            ->limit(5)->get();

        $recentAnime = Anime::where('user_id', $uid)
            ->orderByDesc('updated_at')
            ->limit(5)->get();

        $chartStatus = [
            (int)($stats->watching ?? 0),
            (int)($stats->completed ?? 0),
            (int)($stats->planned ?? 0),
            (int)($stats->dropped ?? 0),
        ];

        return view('user.dashboard', compact(
            'stats','genreRows','nowWatching','recentAnime','chartStatus'
        ));
    }
}
