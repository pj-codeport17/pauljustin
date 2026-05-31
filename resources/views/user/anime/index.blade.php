@extends('layouts.app')
@section('title','My Anime')

@section('content')

<div class="page-header">
    <div>
        <div class="page-header-title">
            <i class="bi bi-collection-play-fill me-2" style="color:var(--accent)"></i>My Anime List
        </div>
        <div class="page-header-sub">
            @if($animes->total() > 0)
                {{ $animes->total() }} {{ Str::plural('title', $animes->total()) }} in your collection
            @else
                Your collection is empty
            @endif
        </div>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <div class="btn-group btn-group-sm" id="viewToggle">
            <button type="button" class="btn btn-outline-secondary active" id="gridBtn" title="Grid View">
                <i class="bi bi-grid-fill"></i>
            </button>
            <button type="button" class="btn btn-outline-secondary" id="listBtn" title="List View">
                <i class="bi bi-list-ul"></i>
            </button>
        </div>
        <a href="{{ route('anime.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Add Anime
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="filter-bar mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-12 col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text" style="background:var(--bg3);border-color:var(--border);color:var(--muted)">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search title..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-6 col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                @foreach($statuses as $k => $v)
                <option value="{{ $k }}" {{ request('status')===$k?'selected':'' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-3">
            <select name="genre" class="form-select form-select-sm">
                <option value="">All Genre</option>
                @foreach($genres as $g)
                <option value="{{ $g }}" {{ request('genre')===$g?'selected':'' }}>{{ $g }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm px-3">Filter</button>
            @if(request()->hasAny(['search','status','genre']))
            <a href="{{ route('anime.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-x-lg"></i>
            </a>
            @endif
        </div>
    </form>
</div>

{{-- ── GRID VIEW ──────────────────────────────────────────────── --}}
<div id="gridView">
@if($animes->count())
<div class="row g-3">
    @foreach($animes as $a)
    <div class="col-6 col-sm-4 col-md-3 col-xl-2">
        <div class="anime-card">
            <div class="anime-card-cover">
                <img src="{{ $a->cover_url }}"
                     onerror="this.src='{{ asset('assets/img/no-cover.svg') }}'"
                     alt="{{ $a->title }}">
                <span class="anime-card-badge bg-{{ $a->status_color }}">
                    {{ $a->status_label }}
                </span>
                <div class="anime-card-actions">
                    <a href="{{ route('anime.edit', $a) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <form method="POST" action="{{ route('anime.destroy', $a) }}"
                          onsubmit="return confirm('Delete &quot;{{ addslashes($a->title) }}&quot;?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="anime-card-body">
                <div class="anime-card-title" title="{{ $a->title }}">{{ $a->title }}</div>
                <div class="anime-card-meta">
                    <span>{{ $a->genre ?? '—' }}</span>
                    @if($a->rating)
                    <span style="color:var(--accent)">★ {{ number_format($a->rating,1) }}</span>
                    @endif
                </div>
                @if($a->total_episodes)
                <div class="mt-1">
                    <div class="d-flex justify-content-between" style="font-size:.62rem;color:var(--muted)">
                        <span>{{ $a->episodes_watched }}/{{ $a->total_episodes }} eps</span>
                        <span>{{ $a->progress }}%</span>
                    </div>
                    <div class="progress mt-1" style="height:3px">
                        <div class="progress-bar" style="width:{{ $a->progress }}%"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <i class="bi bi-collection-play empty-state-icon"></i>
    <div class="empty-state-text">
        {{ request()->hasAny(['search','status','genre'])
            ? 'No anime matches your filter.'
            : 'Your list is empty.' }}
    </div>
    @unless(request()->hasAny(['search','status','genre']))
    <a href="{{ route('anime.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Add Your First Anime
    </a>
    @endunless
</div>
@endif
</div>

{{-- ── LIST VIEW ──────────────────────────────────────────────── --}}
<div id="listView" style="display:none">
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:52px">Cover</th>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Rating</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($animes as $a)
            <tr>
                <td>
                    <img src="{{ $a->cover_url }}"
                         onerror="this.src='{{ asset('assets/img/no-cover.svg') }}'"
                         style="width:38px;height:54px;object-fit:cover;border-radius:6px;border:1px solid var(--border)">
                </td>
                <td>
                    <div class="fw-semibold" style="font-size:.875rem">{{ $a->title }}</div>
                    @if($a->notes)
                    <div class="text-muted text-truncate" style="max-width:180px;font-size:.75rem">{{ $a->notes }}</div>
                    @endif
                </td>
                <td class="text-muted" style="font-size:.82rem">{{ $a->genre ?? '—' }}</td>
                <td><span class="badge bg-{{ $a->status_color }}">{{ $a->status_label }}</span></td>
                <td>
                    <div style="font-size:.78rem">{{ $a->episodes_watched }}/{{ $a->total_episodes ?? '?' }}</div>
                    @if($a->total_episodes)
                    <div class="progress mt-1" style="height:4px;width:80px">
                        <div class="progress-bar" style="width:{{ $a->progress }}%"></div>
                    </div>
                    @endif
                </td>
                <td>
                    @if($a->rating)
                    <span style="color:var(--accent)">★</span>
                    <span style="font-size:.875rem">{{ number_format($a->rating,1) }}</span>
                    @else
                    <span class="text-muted">—</span>
                    @endif
                </td>
                <td class="text-end">
                    <a href="{{ route('anime.edit', $a) }}" class="btn btn-sm btn-outline-secondary me-1">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <form method="POST" action="{{ route('anime.destroy', $a) }}" class="d-inline"
                          onsubmit="return confirm('Delete &quot;{{ addslashes($a->title) }}&quot;?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="bi bi-collection-play empty-state-icon"></i>
                        <div class="empty-state-text">No anime found.</div>
                    </div>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>

{{-- Pagination --}}
@if($animes->hasPages())
<div class="d-flex justify-content-between align-items-center mt-4">
    <small class="text-muted">
        Showing {{ $animes->firstItem() }}–{{ $animes->lastItem() }} of {{ $animes->total() }}
    </small>
    {{ $animes->links('pagination::bootstrap-5') }}
</div>
@endif

@endsection

@section('scripts')
<script>
const gridBtn  = document.getElementById('gridBtn');
const listBtn  = document.getElementById('listBtn');
const gridView = document.getElementById('gridView');
const listView = document.getElementById('listView');

function setView(v) {
    const isGrid = v === 'grid';
    gridView.style.display = isGrid ? '' : 'none';
    listView.style.display = isGrid ? 'none' : '';
    gridBtn.classList.toggle('active', isGrid);
    listBtn.classList.toggle('active', !isGrid);
    localStorage.setItem('animeView', v);
}

const saved = localStorage.getItem('animeView');
if (saved) setView(saved);

gridBtn.addEventListener('click', () => setView('grid'));
listBtn.addEventListener('click', () => setView('list'));
</script>
@endsection
