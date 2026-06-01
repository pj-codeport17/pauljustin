@extends('layouts.app')
@section('title','My Profile')
@section('content')

<div class="page-header">
    <div>
        <div class="page-header-title">My Profile</div>
        <div class="page-header-sub">Manage your account information</div>
    </div>
</div>

<div class="row g-4">
    {{-- Left: Avatar + Stats --}}
    <div class="col-md-3">
        <div class="card profile-card mb-3">
            <div class="avatar-wrap">
                @if($user->avatar)
                <div class="avatar-ring"></div>
                <img src="{{ secure_asset('uploads/avatars/'.$user->avatar) }}" class="avatar-lg">
                @else
                <div class="avatar-ring"></div>
                <div class="avatar-placeholder" style="width:88px;height:88px;font-size:2.2rem">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
                @endif
            </div>
            <div class="fw-bold fs-6 mb-1">{{ $user->name }}</div>
            <div class="small text-muted mb-2">{{ $user->email }}</div>
            <span class="badge bg-primary mb-3">Member</span>
            <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="avatar" id="avatarInput" class="d-none"
                       accept="image/*" onchange="this.form.submit()">
                <button type="button" class="btn btn-outline-secondary btn-sm w-100"
                        onclick="document.getElementById('avatarInput').click()">
                    <i class="bi bi-camera-fill me-1"></i>Change Photo
                </button>
            </form>
            <div class="small text-muted mt-2" style="font-size:.7rem">JPG, PNG, WebP · Max 2MB</div>
        </div>

        <div class="card p-3">
            <div class="section-title mb-3"><i class="bi bi-bar-chart-fill me-1"></i>My Stats</div>
            @foreach([
                ['label'=>'Total Anime', 'val'=>(int)$stats->total, 'color'=>'var(--text)'],
                ['label'=>'Watching',    'val'=>(int)$stats->watching,  'color'=>'#3b82f6'],
                ['label'=>'Completed',   'val'=>(int)$stats->completed, 'color'=>'#22c55e'],
                ['label'=>'Episodes',    'val'=>number_format((int)$stats->eps), 'color'=>'var(--accent)'],
            ] as $s)
            <div class="d-flex justify-content-between align-items-center py-2"
                 style="border-bottom:1px solid var(--border)">
                <span class="text-muted" style="font-size:.82rem">{{ $s['label'] }}</span>
                <span class="fw-bold" style="color:{{ $s['color'] }}">{{ $s['val'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Right: Form --}}
    <div class="col-md-9">
        @if($errors->any())
        <div class="alert alert-danger mb-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil-fill me-2" style="color:var(--accent)"></i>Edit Profile
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PUT')

                    <div class="section-title mb-3">Basic Info</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name',$user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email',$user->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">— Prefer not to say —</option>
                                @foreach(['Male','Female','Prefer not to say'] as $g)
                                <option value="{{ $g }}" {{ old('gender',$user->gender)===$g?'selected':'' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control"
                                   value="{{ old('address',$user->address) }}" placeholder="City, Country">
                        </div>
                    </div>

                    <div class="divider-label">Change Password</div>
                    <p class="text-muted mb-3" style="font-size:.82rem">
                        <i class="bi bi-info-circle me-1"></i>Leave blank to keep your current password.
                    </p>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Min. 8 characters">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="Repeat new password">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check2 me-1"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
