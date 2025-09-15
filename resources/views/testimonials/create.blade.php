@extends('layouts.console')

@section('content')
<div class="container py-4">    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/console')}}" class="btn btn-primary btn-sm">
           <i class="bi bi-arrow-left"></i> Go back
        </a>        
    </div>
    
    <h2 class="mb-4">Add New Testimonial</h2>

    <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="job_title" class="form-label">Job Title</label>
            <input type="text" name="job_title" class="form-control" value="{{ old('job_title') }}">
            @error('job_title') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control">
            @error('profile_picture') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                {{-- Toggle between Cover Image and YouTube Video --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Choose Media Type</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" 
                                name="media_type" id="coverOption" value="cover" 
                                {{ old('media_type', auth()->user()->cover_image ? 'cover' : 'youtube') === 'cover' ? 'checked' : '' }}>
                            <label class="form-check-label" for="coverOption">Cover Image</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" 
                                name="media_type" id="youtubeOption" value="youtube"
                                {{ old('media_type', auth()->user()->cover_image ? 'cover' : 'youtube') === 'youtube' ? 'checked' : '' }}>
                            <label class="form-check-label" for="youtubeOption">YouTube Video</label>
                        </div>
                    </div>
                </div>

                {{-- Cover Image Input --}}
                <div id="coverInput" class="mb-3">
                    <label class="form-label fw-bold">Cover Image</label>
                    <input type="file" name="cover_image" class="form-control">
                    @if(auth()->user()->cover_image)
                        <img src="{{ asset('storage/' . auth()->user()->cover_image) }}" 
                            class="img-fluid mt-2 rounded" alt="Cover Image">
                    @endif
                </div>

                {{-- YouTube Video Input --}}
                <div id="youtubeInput" class="mb-3" style="display:none;">
                    <label class="form-label fw-bold">YouTube Video Link</label>
                    <input type="url" name="youtube_link" 
                        class="form-control" placeholder="https://youtube.com/watch?v=xxxx"
                        value="{{ old('youtube_link', auth()->user()->youtube_link) }}">
                </div>
            </div>
        </div>        

        <div class="mb-3">
            <label for="testimony" class="form-label">Testimony *</label>
            <textarea name="testimony" id="article-ckeditor" rows="6" class="form-control">{{ old('testimony') }}</textarea>
            @error('testimony') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="ratings" class="form-label">Ratings (1 to 5) *</label>
            <select name="ratings" class="form-select" required>
                <option value="">-- Select Rating --</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('ratings') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>
            @error('ratings') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Submit
        </button>
    </form>
</div>
{{-- Script to toggle inputs --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function toggleMediaInput() {
            const cover = document.getElementById('coverInput');
            const youtube = document.getElementById('youtubeInput');
            const type = document.querySelector('input[name="media_type"]:checked').value;
            if (type === 'cover') {
                cover.style.display = 'block';
                youtube.style.display = 'none';
            } else {
                cover.style.display = 'none';
                youtube.style.display = 'block';
            }
        }

        document.querySelectorAll('input[name="media_type"]').forEach(el => {
            el.addEventListener('change', toggleMediaInput);
        });

        toggleMediaInput(); // initial load
    });
</script>
@endsection
