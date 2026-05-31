@extends('layouts.app')
@section('title','Edit Anime')
@section('content')

<div class="page-header">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('anime.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <div class="page-header-title">Edit Anime</div>
            <div class="page-header-sub text-truncate" style="max-width:300px">{{ $anime->title }}</div>
        </div>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger mb-3">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
</div>
@endif

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('anime.update', $anime) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-4">
                        {{-- Cover --}}
                        <div class="col-md-3">
                            <label class="form-label">Cover Image</label>
                            <div class="anime-cover-upload"
                                 onclick="document.getElementById('coverInput').click()">
                                <img id="coverPreview"
                                     src="{{ $anime->cover_url }}"
                                     onerror="this.src='{{ asset('assets/img/no-cover.svg') }}'"
                                     style="width:100%;height:100%;object-fit:cover">
                                <div class="cover-upload-overlay">
                                    <i class="bi bi-camera-fill fs-5"></i>
                                    <div style="font-size:.75rem;margin-top:4px">Change Cover</div>
                                </div>
                            </div>
                            <input type="file" name="cover_image" id="coverInput" class="d-none"
                                   accept="image/*" onchange="previewCover(this)">
                            <div class="text-muted mt-2" style="font-size:.72rem;text-align:center">
                                JPG, PNG, WebP · Max 3MB
                            </div>
                        </div>

                        {{-- Fields --}}
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                       value="{{ old('title', $anime->title) }}" required autofocus>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Genre</label>
                                    <select name="genre" class="form-select">
                                        <option value="">— Select Genre —</option>
                                        @foreach($genres as $g)
                                        <option value="{{ $g }}" {{ old('genre',$anime->genre)===$g?'selected':'' }}>{{ $g }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required>
                                        @foreach($statuses as $k => $v)
                                        <option value="{{ $k }}" {{ old('status',$anime->status)===$k?'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Total Episodes</label>
                                    <input type="number" name="total_episodes" class="form-control" min="0"
                                           value="{{ old('total_episodes',$anime->total_episodes) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Watched</label>
                                    <input type="number" name="episodes_watched" class="form-control" min="0"
                                           value="{{ old('episodes_watched',$anime->episodes_watched) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Rating <span class="text-muted" style="font-size:.72rem">(0–10)</span></label>
                                    <input type="number" name="rating" class="form-control"
                                           min="0" max="10" step="0.1"
                                           value="{{ old('rating',$anime->rating) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="3"
                                          maxlength="1000">{{ old('notes',$anime->notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="divider-label">Save Changes</div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check2 me-1"></i>Save Changes
                        </button>
                        <a href="{{ route('anime.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function previewCover(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { document.getElementById('coverPreview').src = e.target.result; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
