@use('Illuminate\Support\Facades\Storage')
@extends('layouts.app')
@section('title', 'Profile')

@push('scripts')
<style>
    .profile-form .form-label { color: #fff; }
</style>
@endpush
@section('content')
<h4 class="fw-bold mb-4" style="color:#a78bfa"><i class="bi bi-person-circle me-2"></i>My Profile</h4>

<div class="row g-4">
    <div class="col-12 col-md-4">
        <div class="card p-4 text-center">
            @if($user->profile_picture)
                <img src="{{ Storage::url($user->profile_picture) }}" class="avatar-lg mx-auto mb-3">
            @else
                <div class="mx-auto mb-3" style="width:110px;height:110px;border-radius:50%;background:#7c3aed;display:flex;align-items:center;justify-content:center;font-size:2.5rem;font-weight:700;color:#fff;border:3px solid #a78bfa">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
            @endif
            <h5 class="fw-bold mb-1" style="color:#fff">{{ $user->name }}</h5>
            <div style="color:#fff;font-size:.9rem">{{ $user->email }}</div>
            @if($user->gender)
                <div class="mt-2"><span class="badge bg-secondary">{{ $user->gender }}</span></div>
            @endif
            @if($user->address)
                <div class="mt-2" style="color:#fff;font-size:.85rem"><i class="bi bi-geo-alt me-1"></i>{{ $user->address }}</div>
            @endif
            <div class="mt-3" style="color:#fff;font-size:.8rem">Member since {{ $user->created_at->format('M Y') }}</div>
        </div>
    </div>

    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header fw-semibold" style="color:#a78bfa">Edit Profile</div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-form">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select gender</option>
                                @foreach(['Male','Female','Other'] as $g)
                                    <option value="{{ $g }}" {{ old('gender', $user->gender) == $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}" placeholder="Optional">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">New Password <small style="color:#fff">(leave blank to keep)</small></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
