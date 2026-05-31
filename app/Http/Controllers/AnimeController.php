<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimeController extends Controller {

    private array $genres = [
        'Action','Adventure','Comedy','Drama','Fantasy','Horror',
        'Isekai','Mecha','Mystery','Romance','Sci-Fi',
        'Slice of Life','Sports','Supernatural','Thriller'
    ];
    private array $statuses = [
        'watching'      => 'Watching',
        'completed'     => 'Completed',
        'plan_to_watch' => 'Plan to Watch',
        'dropped'       => 'Dropped',
    ];

    public function index(Request $request) {
        $query = Anime::where('user_id', auth()->id());
        if ($s = $request->search) $query->where('title','like',"%$s%");
        if ($s = $request->status) $query->where('status', $s);
        if ($g = $request->genre)  $query->where('genre', $g);

        $animes   = $query->orderByDesc('updated_at')->paginate(12)->withQueryString();
        $genres   = $this->genres;
        $statuses = $this->statuses;
        return view('user.anime.index', compact('animes','genres','statuses'));
    }

    public function create() {
        $genres   = $this->genres;
        $statuses = $this->statuses;
        return view('user.anime.create', compact('genres','statuses'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'genre'            => 'nullable|string|max:100',
            'status'           => 'required|in:watching,completed,plan_to_watch,dropped',
            'total_episodes'   => 'nullable|integer|min:0',
            'episodes_watched' => 'nullable|integer|min:0',
            'rating'           => 'nullable|numeric|min:0|max:10',
            'notes'            => 'nullable|string|max:1000',
            'cover_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = 'cover_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/anime_covers'), $filename);
            $data['cover_image'] = $filename;
        }

        auth()->user()->animes()->create($data);

        return redirect()->route('anime.index')
            ->with('success', '"' . $data['title'] . '" added to your list!');
    }

    public function edit(Anime $anime) {
        abort_if($anime->user_id !== auth()->id(), 403);
        $genres   = $this->genres;
        $statuses = $this->statuses;
        return view('user.anime.edit', compact('anime','genres','statuses'));
    }

    public function update(Request $request, Anime $anime) {
        abort_if($anime->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'genre'            => 'nullable|string|max:100',
            'status'           => 'required|in:watching,completed,plan_to_watch,dropped',
            'total_episodes'   => 'nullable|integer|min:0',
            'episodes_watched' => 'nullable|integer|min:0',
            'rating'           => 'nullable|numeric|min:0|max:10',
            'notes'            => 'nullable|string|max:1000',
            'cover_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete old cover
            if ($anime->cover_image) {
                $old = public_path('uploads/anime_covers/' . $anime->cover_image);
                if (file_exists($old)) unlink($old);
            }
            $file = $request->file('cover_image');
            $filename = 'cover_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/anime_covers'), $filename);
            $data['cover_image'] = $filename;
        }

        $anime->update($data);

        return redirect()->route('anime.index')
            ->with('success', '"' . $data['title'] . '" updated!');
    }

    public function destroy(Anime $anime) {
        abort_if($anime->user_id !== auth()->id(), 403);
        // Delete cover image
        if ($anime->cover_image) {
            $path = public_path('uploads/anime_covers/' . $anime->cover_image);
            if (file_exists($path)) unlink($path);
        }
        $title = $anime->title;
        $anime->delete();
        return redirect()->route('anime.index')
            ->with('success', '"' . $title . '" removed from your list.');
    }
}
