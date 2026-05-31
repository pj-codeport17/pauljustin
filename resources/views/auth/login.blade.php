<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In — AniTrack</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

@if(session('success'))
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast show align-items-center text-bg-success border-0">
        <div class="d-flex">
            <div class="toast-body"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">
            <i class="bi bi-play-circle-fill"></i> AniTrack
        </div>
        <div class="auth-subtitle">Sign in to track your anime journey</div>

        @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--bg3);border-color:var(--border);color:var(--muted)">
                        <i class="bi bi-envelope-fill"></i>
                    </span>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--bg3);border-color:var(--border);color:var(--muted)">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password" name="password" id="loginPass" class="form-control" placeholder="••••••••" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePass('loginPass',this)" tabindex="-1">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </button>
        </form>

        <div class="divider-label">or</div>

        <p class="text-center mb-0" style="font-size:.875rem;color:var(--muted)">
            Don't have an account?
            <a href="{{ route('register') }}" style="color:var(--accent);font-weight:600">Create one free</a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePass(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
// Auto-dismiss toast
document.querySelectorAll('.toast').forEach(el => {
    setTimeout(() => bootstrap.Toast.getOrCreateInstance(el).hide(), 4000);
});
</script>
</body>
</html>
