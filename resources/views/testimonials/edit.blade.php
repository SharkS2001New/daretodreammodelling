@extends('layouts.console')

@section('content')
<div class="container py-4">    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/console')}}" class="btn btn-primary btn-sm">
           <i class="bi bi-arrow-left"></i> Go back
        </a>        
    </div>

    <h2 class="mb-4">Update Testimony</h2>

    <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Full Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name) }}" required>
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Job Title --}}
        <div class="mb-3">
            <label for="job_title" class="form-label">Job Title</label>
            <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $testimonial->job_title) }}">
            @error('job_title') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Profile Picture --}}
        <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control">
            @if ($testimonial->profile_picture)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $testimonial->profile_picture) }}" alt="{{ $testimonial->name }}" width="100" class="rounded-circle">
                </div>
            @endif
            @error('profile_picture') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Media Type Toggle --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Choose Media Type</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" 
                                name="media_type" id="coverOption" value="cover" 
                                {{ old('media_type', $testimonial->cover_image ? 'cover' : 'youtube') === 'cover' ? 'checked' : '' }}>
                            <label class="form-check-label" for="coverOption">Cover Image</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" 
                                name="media_type" id="youtubeOption" value="youtube"
                                {{ old('media_type', $testimonial->cover_image ? 'cover' : 'youtube') === 'youtube' ? 'checked' : '' }}>
                            <label class="form-check-label" for="youtubeOption">YouTube Video</label>
                        </div>
                    </div>
                </div>

                {{-- Cover Image Input --}}
                <div id="coverInput" class="mb-3" style="{{ old('media_type', $testimonial->cover_image ? 'cover' : 'youtube') === 'cover' ? '' : 'display:none;' }}">
                    <label class="form-label fw-bold">Cover Image</label>
                    <input type="file" name="cover_image" class="form-control">
                    @if($testimonial->cover_image)
                        <img src="{{ asset('storage/' . $testimonial->cover_image) }}" 
                            class="img-fluid mt-2 rounded" alt="Cover Image">
                    @endif
                </div>

                {{-- YouTube Video Input --}}
                <div id="youtubeInput" class="mb-3" style="{{ old('media_type', $testimonial->cover_image ? 'cover' : 'youtube') === 'youtube' ? '' : 'display:none;' }}">
                    <label class="form-label fw-bold">YouTube Video Link</label>
                    <input type="url" name="youtube_link" 
                        class="form-control" placeholder="https://youtube.com/watch?v=xxxx"
                        value="{{ old('youtube_link', $testimonial->youtube_link) }}">
                </div>
            </div>
        </div>       

        {{-- Testimony --}}
        <div class="mb-3">
            <label for="testimony" class="form-label">Testimony *</label>
            <textarea name="testimony" id="article-ckeditor" rows="6" class="form-control" required>{{ old('testimony', $testimonial->testimony) }}</textarea>
            @error('testimony') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Ratings --}}
        <div class="mb-3">
            <label for="ratings" class="form-label">Ratings (1 to 5) *</label>
            <select name="ratings" class="form-select" required>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('ratings', $testimonial->ratings) == $i ? 'selected' : '' }}>
                        {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                    </option>
                @endfor
            </select>
            @error('ratings') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update
        </button>
    </form>
</div>

{{-- Script to toggle inputs --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const coverOption = document.getElementById("coverOption");
        const youtubeOption = document.getElementById("youtubeOption");
        const coverInput = document.getElementById("coverInput");
        const youtubeInput = document.getElementById("youtubeInput");

        function toggleInputs() {
            if (coverOption.checked) {
                coverInput.style.display = "block";
                youtubeInput.style.display = "none";
            } else {
                coverInput.style.display = "none";
                youtubeInput.style.display = "block";
            }
        }

        coverOption.addEventListener("change", toggleInputs);
        youtubeOption.addEventListener("change", toggleInputs);

        toggleInputs(); // run on page load
    });
</script>
@endsection
