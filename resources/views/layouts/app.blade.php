@use('Illuminate\Support\Facades\Storage')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AniTrack – @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #0f0f1a; color: #e0e0e0; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            width: 240px; min-height: 100vh; background: #16162a;
            border-right: 1px solid #2a2a4a; position: fixed; top: 0; left: 0; z-index: 100;
        }
        .sidebar .brand { padding: 1.5rem 1.2rem; font-size: 1.3rem; font-weight: 700;
            color: #a78bfa; border-bottom: 1px solid #2a2a4a; }
        .sidebar .nav-link { color: #b0b0c8; padding: .6rem 1.2rem; border-radius: 8px;
            margin: 2px 8px; transition: all .2s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #2a2a4a; color: #a78bfa; }
        .sidebar .nav-link i { margin-right: 8px; }
        .main-content { margin-left: 240px; padding: 2rem; min-height: 100vh; }
        .card { background: #16162a; border: 1px solid #2a2a4a; border-radius: 12px; }
        .card-header { background: #1e1e38; border-bottom: 1px solid #2a2a4a; }
        .table { color: #e0e0e0; }
        .table thead th { background: #1e1e38; color: #a78bfa; border-color: #2a2a4a; }
        .table td, .table th { border-color: #2a2a4a; vertical-align: middle; }
        .table tbody tr:hover { background: #1e1e38; }
        .btn-primary { background: #7c3aed; border-color: #7c3aed; }
        .btn-primary:hover { background: #6d28d9; border-color: #6d28d9; }
        .form-control, .form-select { background: #1e1e38; border-color: #2a2a4a; color: #e0e0e0; }
        .form-control:focus, .form-select:focus { background: #1e1e38; border-color: #7c3aed; color: #e0e0e0; box-shadow: 0 0 0 .2rem rgba(124,58,237,.25); }
        .form-control::placeholder { color: #666; }
        .modal-content { background: #16162a; border: 1px solid #2a2a4a; color: #e0e0e0; }
        .modal-header { border-bottom: 1px solid #2a2a4a; }
        .modal-footer { border-top: 1px solid #2a2a4a; }
        .toast-container { z-index: 9999; }
        .avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .avatar-lg { width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 3px solid #7c3aed; }
        .avatar-placeholder { width: 40px; height: 40px; border-radius: 50%; background: #7c3aed;
            display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff; font-size:.9rem; }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column">
    <div class="brand"><i class="bi bi-play-circle-fill"></i> AniTrack</div>
    <nav class="nav flex-column mt-3 flex-grow-1">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('anime.index') }}" class="nav-link {{ request()->routeIs('anime.*') ? 'active' : '' }}">
            <i class="bi bi-collection-play"></i> My Anime List
        </a>
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
        </a>
        <a href="{{ route('profile.show') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profile
        </a>
    </nav>
    <div class="p-3" style="border-top:1px solid #2a2a4a">
        <div class="d-flex align-items-center gap-2 mb-2">
            @if(auth()->user()->profile_picture)
                <img src="{{ Storage::url(auth()->user()->profile_picture) }}" class="avatar">
            @else
                <div class="avatar-placeholder">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
            @endif
            <div style="overflow:hidden">
                <div class="fw-semibold text-truncate" style="font-size:.85rem">{{ auth()->user()->name }}</div>
                <div class="text-truncate" style="font-size:.72rem;color:#888">{{ auth()->user()->email }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </form>
    </div>
</div>

<div class="main-content">
    @yield('content')
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    @if(session('toast_success'))
    <div class="toast align-items-center text-bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body"><i class="bi bi-check-circle me-2"></i>{{ session('toast_success') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endif
    @if(session('toast_error'))
    <div class="toast align-items-center text-bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body"><i class="bi bi-x-circle me-2"></i>{{ session('toast_error') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
@stack('scripts')
<script>
    document.querySelectorAll('.toast').forEach(el => {
        new bootstrap.Toast(el, { delay: 4000 }).show();
    });
</script>
</body>
</html>
