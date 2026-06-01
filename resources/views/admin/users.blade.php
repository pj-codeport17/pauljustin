@extends('layouts.app')
@section('title','Users Management')
@section('content')

<div class="page-header">
    <div>
        <div class="page-header-title">Users Management</div>
        <div class="page-header-sub">{{ $users->total() }} registered {{ Str::plural('user', $users->total()) }}</div>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-primary bg-opacity-10"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-value">{{ $users->total() }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-success bg-opacity-10"><i class="bi bi-person-check-fill"></i></div>
            <div>
                <div class="stat-value">{{ $newToday }}</div>
                <div class="stat-label">New Today</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-warning bg-opacity-10"><i class="bi bi-collection-play-fill"></i></div>
            <div>
                <div class="stat-value">{{ $totalAnime }}</div>
                <div class="stat-label">Total Anime</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-danger bg-opacity-10"><i class="bi bi-envelope-fill"></i></div>
            <div>
                <div class="stat-value">{{ $unread }}</div>
                <div class="stat-label">Unread Msgs</div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <span>
            <i class="bi bi-people-fill me-2" style="color:var(--accent)"></i>All Users
        </span>

        <form method="GET" action="{{ secure_url(route('admin.users', [], false)) }}" class="d-flex gap-2">
            <div class="input-group input-group-sm" style="width:240px">
                <span class="input-group-text" style="background:var(--bg3);border-color:var(--border);color:var(--muted)">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text"
                       name="search"
                       class="form-control form-control-sm"
                       placeholder="Name or email..."
                       value="{{ request('search') }}">
            </div>

            <button type="submit" class="btn btn-primary btn-sm px-3">Search</button>

            @if(request('search'))
                <a href="{{ secure_url(route('admin.users', [], false)) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Anime</th>
                    <th>Joined</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse($users as $i => $u)
                <tr>
                    <td class="text-muted" style="font-size:.78rem">{{ $users->firstItem() + $i }}</td>

                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($u->avatar)
                               <img src="{{ asset('storage/avatars/'.$user->avatar) }}" class="avatar-lg">
                                     width="32"
                                     height="32"
                                     class="rounded-circle"
                                     alt="{{ $u->name }}"
                                     style="object-fit:cover;border:2px solid var(--border2)">
                            @else
                                <div class="avatar-placeholder-sm" style="width:32px;height:32px;font-size:.78rem">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                            @endif

                            <span class="fw-semibold" style="font-size:.875rem">{{ $u->name }}</span>
                        </div>
                    </td>

                    <td class="text-muted" style="font-size:.82rem">{{ $u->email }}</td>
                    <td class="text-muted" style="font-size:.82rem">{{ $u->gender ?? '—' }}</td>
                    <td><span class="badge bg-primary">{{ $u->animes_count }}</span></td>
                    <td class="text-muted" style="font-size:.78rem">{{ $u->created_at->format('M j, Y') }}</td>

                    <td class="text-end">
                        <form method="POST"
                              action="{{ secure_url(route('admin.users.destroy', $u, false)) }}"
                              class="d-inline"
                              onsubmit="return confirm('Remove user &quot;{{ addslashes($u->name) }}&quot;? This will also delete all their anime entries.')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete user">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="bi bi-people empty-state-icon"></i>
                            <div class="empty-state-text">
                                {{ request('search')
                                    ? 'No users matching "'.request('search').'".'
                                    : 'No users registered yet.' }}
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="card-footer py-2 d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }}
            </small>
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection