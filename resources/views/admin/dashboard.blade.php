@extends('layouts.app')
@section('title','Admin Dashboard')
@section('content')

<div class="page-header">
    <div>
        <div class="page-header-title">Admin Dashboard</div>
        <div class="page-header-sub">Platform overview and analytics</div>
    </div>
    <a href="{{ route('admin.users') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-people-fill me-1"></i>Manage Users
    </a>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-primary bg-opacity-10"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-label">Users</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-success bg-opacity-10"><i class="bi bi-collection-play-fill"></i></div>
            <div>
                <div class="stat-value">{{ $totalAnime }}</div>
                <div class="stat-label">Anime Added</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-warning bg-opacity-10"><i class="bi bi-envelope-fill"></i></div>
            <div>
                <div class="stat-value">{{ $totalMsgs }}</div>
                <div class="stat-label">Total Messages</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-danger bg-opacity-10"><i class="bi bi-envelope-exclamation-fill"></i></div>
            <div>
                <div class="stat-value">{{ $unread }}</div>
                <div class="stat-label">Unread</div>
            </div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-graph-up me-2" style="color:var(--accent)"></i>
                User Registrations — Last 14 Days
            </div>
            <div class="card-body" style="height:240px">
                <canvas id="regChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-trophy-fill me-2" style="color:var(--accent)"></i>
                Top Users by Anime
            </div>
            <div class="card-body" style="height:240px">
                <canvas id="topChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Recent Users Table --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            <i class="bi bi-person-plus-fill me-2" style="color:var(--accent)"></i>
            Recently Registered Users
        </span>
        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary">
            View All <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Anime</th>
                    <th>Joined</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @forelse($recentUsers as $i => $u)
            <tr>
                <td class="text-muted" style="font-size:.78rem">{{ $i+1 }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        @if($u->avatar)
                        <img src="{{ secure_asset('uploads/avatars/'.$u->avatar) }}"
                             width="30" height="30" class="rounded-circle"
                             style="object-fit:cover;border:2px solid var(--border2)">
                        @else
                        <div class="avatar-placeholder-sm" style="width:30px;height:30px;font-size:.72rem">
                            {{ strtoupper(substr($u->name,0,1)) }}
                        </div>
                        @endif
                        <span class="fw-semibold" style="font-size:.875rem">{{ $u->name }}</span>
                    </div>
                </td>
                <td class="text-muted" style="font-size:.82rem">{{ $u->email }}</td>
                <td><span class="badge bg-primary">{{ $u->animes_count }}</span></td>
                <td class="text-muted" style="font-size:.78rem">{{ $u->created_at->format('M j, Y') }}</td>
                <td><span class="badge bg-success">Active</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="bi bi-people empty-state-icon"></i>
                        <div class="empty-state-text">No users registered yet.</div>
                    </div>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('regChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($regLabels) !!},
            datasets: [{
                label:'New Users',
                data:{!! json_encode($regData) !!},
                borderColor:'#f5c518',
                backgroundColor:'rgba(245,197,24,.08)',
                tension:.4, fill:true,
                pointBackgroundColor:'#f5c518',
                pointBorderColor:'var(--bg2)',
                pointBorderWidth:2,
                pointRadius:4,
                pointHoverRadius:6
            }]
        },
        options: {
            responsive:true, maintainAspectRatio:false,
            plugins:{ legend:{display:false} },
            scales:{
                x:{ticks:{color:'#8b80b0',font:{size:11}},grid:{color:'rgba(46,38,85,.5)'}},
                y:{ticks:{color:'#8b80b0',stepSize:1,font:{size:11}},grid:{color:'rgba(46,38,85,.5)'},beginAtZero:true}
            }
        }
    });

    new Chart(document.getElementById('topChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($topUsers->pluck('name')) !!},
            datasets: [{
                label:'Anime',
                data:{!! json_encode($topUsers->pluck('animes_count')) !!},
                backgroundColor:'rgba(245,197,24,.65)',
                borderColor:'#f5c518',
                borderWidth:1,
                borderRadius:6
            }]
        },
        options: {
            indexAxis:'y', responsive:true, maintainAspectRatio:false,
            plugins:{ legend:{display:false} },
            scales:{
                x:{ticks:{color:'#8b80b0',stepSize:1},grid:{color:'rgba(46,38,85,.5)'},beginAtZero:true},
                y:{ticks:{color:'#f0ecff',font:{size:11}},grid:{color:'transparent'}}
            }
        }
    });
});
</script>
@endsection
