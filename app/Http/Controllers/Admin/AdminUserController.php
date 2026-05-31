<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller {

    public function index(Request $request) {
        $query = User::where('is_admin', false)->withCount('animes');
        if ($s = $request->search)
            $query->where(fn($q) => $q->where('name','like',"%$s%")->orWhere('email','like',"%$s%"));
        $users = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        $newToday   = User::where('is_admin', false)->whereDate('created_at', today())->count();
        $totalAnime = \App\Models\Anime::count();
        $unread     = \App\Models\Contact::where('is_read', false)->count();

        return view('admin.users', compact('users','newToday','totalAnime','unread'));
    }

    public function destroy(User $user) {
        abort_if($user->id === auth()->id(), 403);
        abort_if($user->is_admin, 403);
        $name = $user->name;
        $user->delete();
        return back()->with('success', '"' . $name . '" has been removed.');
    }
}
