@extends('layouts.app')
@section('title', 'My Anime List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0" style="color:#a78bfa"><i class="bi bi-collection-play me-2"></i>My Anime List</h4>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAnimeModal">
        <i class="bi bi-plus-lg me-1"></i>Add Anime
    </button>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Status</th>
                    <th>Episodes</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($animes as $anime)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $anime->title }}</td>
                    <td><span class="badge bg-secondary">{{ $anime->genre }}</span></td>
                    <td>
                        @php
                            $colors = ['Watching'=>'primary','Completed'=>'success','Plan to Watch'=>'warning','Dropped'=>'danger'];
                        @endphp
                        <span class="badge bg-{{ $colors[$anime->status] ?? 'secondary' }}">{{ $anime->status }}</span>
                    </td>
                    <td>{{ $anime->episodes }}</td>
                    <td>
                        @if($anime->rating)
                            <span style="color:#f59e0b">{{ $anime->rating }}/10</span>
                        @else
                            <span style="color:#555">—</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-warning me-1"
                            data-bs-toggle="modal" data-bs-target="#editAnimeModal"
                            data-id="{{ $anime->id }}"
                            data-title="{{ $anime->title }}"
                            data-genre="{{ $anime->genre }}"
                            data-status="{{ $anime->status }}"
                            data-episodes="{{ $anime->episodes }}"
                            data-rating="{{ $anime->rating }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form method="POST" action="{{ route('anime.destroy', $anime) }}" class="d-inline"
                            onsubmit="return confirm('Remove this anime?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4" style="color:#666">No anime added yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Anime Modal --}}
<div class="modal fade" id="addAnimeModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('anime.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:#a78bfa">Add Anime</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('anime._form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Add Anime</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Anime Modal --}}
<div class="modal fade" id="editAnimeModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="editAnimeForm">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:#a78bfa">Edit Anime</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('anime._form', ['edit' => true])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('editAnimeModal').addEventListener('show.bs.modal', function(e) {
    const b = e.relatedTarget;
    const f = document.getElementById('editAnimeForm');
    f.action = '/anime/' + b.dataset.id;
    f.querySelector('[name=title]').value    = b.dataset.title;
    f.querySelector('[name=genre]').value    = b.dataset.genre;
    f.querySelector('[name=status]').value   = b.dataset.status;
    f.querySelector('[name=episodes]').value = b.dataset.episodes;
    f.querySelector('[name=rating]').value   = b.dataset.rating;
});
</script>
@endpush
