@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h4 class="fw-bold mb-4" style="color:#a78bfa"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center">
            <div style="font-size:2rem;color:#a78bfa"><i class="bi bi-people-fill"></i></div>
            <div class="fs-2 fw-bold">{{ $totalUsers }}</div>
            <div style="color:#888;font-size:.85rem">Total Users</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center">
            <div style="font-size:2rem;color:#34d399"><i class="bi bi-collection-play-fill"></i></div>
            <div class="fs-2 fw-bold">{{ $totalAnime }}</div>
            <div style="color:#888;font-size:.85rem">My Anime Entries</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center">
            <div style="font-size:2rem;color:#60a5fa"><i class="bi bi-eye-fill"></i></div>
            <div class="fs-2 fw-bold">{{ $statusCounts['Watching'] ?? 0 }}</div>
            <div style="color:#888;font-size:.85rem">Watching</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center">
            <div style="font-size:2rem;color:#f59e0b"><i class="bi bi-check-circle-fill"></i></div>
            <div class="fs-2 fw-bold">{{ $statusCounts['Completed'] ?? 0 }}</div>
            <div style="color:#888;font-size:.85rem">Completed</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header fw-semibold" style="color:#a78bfa">Anime by Status</div>
            <div class="card-body"><canvas id="statusChart"></canvas></div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header fw-semibold" style="color:#a78bfa">Anime by Genre</div>
            <div class="card-body"><canvas id="genreChart"></canvas></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
Chart.defaults.color = '#b0b0c8';

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: @json($statusCounts->keys()),
        datasets: [{ data: @json($statusCounts->values()), backgroundColor: ['#3b82f6','#10b981','#f59e0b','#ef4444'], borderWidth: 0 }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

new Chart(document.getElementById('genreChart'), {
    type: 'bar',
    data: {
        labels: @json($genreCounts->keys()),
        datasets: [{ label: 'Count', data: @json($genreCounts->values()), backgroundColor: '#7c3aed', borderRadius: 6 }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: '#2a2a4a' } },
            y: { grid: { color: '#2a2a4a' }, ticks: { stepSize: 1 } }
        }
    }
});
</script>
@endpush
