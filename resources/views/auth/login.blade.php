<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AniTrack – Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #0f0f1a; color: #e0e0e0; min-height: 100vh; display:flex; align-items:center; justify-content:center; }
        .auth-card { background: #16162a; border: 1px solid #2a2a4a; border-radius: 16px; padding: 2.5rem; width: 100%; max-width: 420px; }
        .brand { font-size: 1.8rem; font-weight: 700; color: #a78bfa; text-align:center; margin-bottom: .3rem; }
        .form-control { background: #1e1e38; border-color: #2a2a4a; color: #e0e0e0; }
        .form-control:focus { background: #1e1e38; border-color: #7c3aed; color: #e0e0e0; box-shadow: 0 0 0 .2rem rgba(124,58,237,.25); }
        .form-control::placeholder { color: #555; }
        .form-label { color: #b0b0c8; font-size: .9rem; }
        .btn-primary { background: #7c3aed; border-color: #7c3aed; }
        .btn-primary:hover { background: #6d28d9; border-color: #6d28d9; }
        .toast-container { z-index: 9999; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="brand"><i class="bi bi-play-circle-fill"></i> AniTrack</div>
    <p class="text-center mb-4" style="color:#888;font-size:.9rem">Sign in to your account</p>

    @if($errors->any())
        <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}" required>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="text-center mt-3" style="color:#888;font-size:.9rem">
        No account? <a href="{{ route('register') }}" style="color:#a78bfa">Register</a>
    </p>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.toast').forEach(el => new bootstrap.Toast(el, { delay: 4000 }).show());
</script>
</body>
</html>
