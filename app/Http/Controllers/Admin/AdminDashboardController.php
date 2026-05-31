<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Anime;
use App\Models\Contact;

class AdminDashboardController extends Controller {

    public function index() {
        $totalUsers  = User::where('is_admin', false)->count();
        $totalAnime  = Anime::count();
        $totalMsgs   = Contact::count();
        $unread      = Contact::where('is_read', false)->count();

        $regChart = User::where('is_admin', false)
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->selectRaw('DATE(created_at) as day, COUNT(*) as cnt')
            ->groupBy('day')->orderBy('day')
            ->get()->keyBy('day');

        $regLabels = []; $regData = [];
        for ($i = 13; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $regLabels[] = now()->subDays($i)->format('M j');
            $regData[]   = (int)($regChart[$d]->cnt ?? 0);
        }

        $topUsers = User::where('is_admin', false)
            ->withCount('animes')->orderByDesc('animes_count')->limit(5)->get();

        $recentUsers = User::where('is_admin', false)
            ->withCount('animes')->orderByDesc('created_at')->limit(7)->get();

        return view('admin.dashboard', compact(
            'totalUsers','totalAnime','totalMsgs','unread',
            'regLabels','regData','topUsers','recentUsers'
        ));
    }
}
