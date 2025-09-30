@extends('layouts.gallery')

@section('content')
<div class="container">
    <div class="profile-header text-left mb-4">
        <div class="row align-items-center mb-4">
            <!-- Left: Profile Info -->
            <div class="col d-flex align-items-center">
                <!-- Profile Picture -->
                <div class="me-3">
                    <img src="{{ asset('storage/' . ($user->publicInfo->profile_picture ?? 'default.jpg')) }}"
                        alt="{{ $user->name }}"
                        class="rounded-circle"
                        width="120">
                </div>

                <!-- Profile Info -->
                <div>
                    <h2 class="mb-1">
                        {{ $user->publicInfo?->display_name ?? $user->name }}
                    </h2>
                    <span class="badge bg-secondary">{{ $user->user_type }}</span>
                    <p class="mb-0 mt-2">
                        <i class="bx bx-map"></i>
                        {{ $user->publicInfo?->location ?? 'Location not set' }}
                    </p>
                </div>
            </div>

            <!-- Right: Modelling Page Button -->
            <div class="col-auto text-end">
                <a href="/dashboard" class="btn btn-outline-primary btn-sm">
                    View My Modelling Dashboard
                </a>
            </div>
        </div>

        <br/>
        <div class="stats d-flex justify-content-center gap-4 my-3 text-muted small">
            <div>
                Photo loves: <strong>{{ $stats['photo_likes'] }}</strong>
            </div>
            <div>
               Photo Views: <strong>{{ $stats['photo_views'] }}</strong>
            </div>
            <div>
                Video loves: <strong>{{ $stats['video_likes'] }}</strong>
            </div>
            <div>
                Video Views: <strong>{{ $stats['video_views'] }}</strong>
            </div>
            <div>
                Followers: <strong>{{ $stats['followers'] }}</strong>
            </div>
            <div>
                Last login: 
                <strong>
                    {{ $user->last_login ? ($user->last_login->copy()->addHours(3)->isToday() 
                        ? 'Today ' . $user->last_login->copy()->addHours(3)->format('h:i A') 
                        : $user->last_login->copy()->addHours(3)->format('M d, Y h:i A')) 
                        : 'Never' }}
                </strong>
            </div>
        </div>

        <!-- Linked Accounts -->
        <div class="d-flex justify-content-center gap-4 mt-3">
            @if($user->linkedAccount && $user->linkedAccount->instagram_url)
                <a href="{{ $user->linkedAccount->instagram_url }}" target="_blank" class="social-link text-decoration-none text-dark">
                    <i class="bi bi-instagram fs-4"></i>
                </a>
            @endif

            @if($user->linkedAccount && $user->linkedAccount->twitter_url)
                <a href="{{ $user->linkedAccount->twitter_url }}" target="_blank" class="social-link text-decoration-none text-dark">
                    <i class="bi bi-twitter-x fs-4"></i>
                </a>
            @endif

            @if($user->linkedAccount && $user->linkedAccount->tiktok_url)
                <a href="{{ $user->linkedAccount->tiktok_url }}" target="_blank" class="social-link text-decoration-none text-dark">
                    <i class="bi bi-tiktok fs-4"></i>
                </a>
            @endif

            @if($user->linkedAccount && $user->linkedAccount->youtube_url)
                <a href="{{ $user->linkedAccount->youtube_url }}" target="_blank" class="social-link text-decoration-none text-dark">
                    <i class="bi bi-youtube fs-4"></i>
                </a>
            @endif

            @if($user->linkedAccount && $user->linkedAccount->other_url)
                <a href="{{ $user->linkedAccount->other_url }}" target="_blank" class="social-link text-decoration-none text-dark">
                    <i class="bi bi-globe fs-4"></i>
                </a>
            @endif
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs justify-content-center" id="profileTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="photos-tab" data-bs-toggle="tab" href="#photos" role="tab">Photos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="videos-tab" data-bs-toggle="tab" href="#videos" role="tab">Videos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tiktok-tab" data-bs-toggle="tab" href="#tiktok" role="tab">TikTok</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="about-tab" data-bs-toggle="tab" href="#about" role="tab">About</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-4" id="profileTabsContent">
        <!-- Photos -->
        <div class="tab-pane fade show active" id="photos" role="tabpanel">
            <div class="row">
                <!-- Upload Card (always first) -->
                <div class="col-md-4 col-lg-3 mb-3">
                    <div class="card mb-4">
                        <div class="card-body text-center p-4">
                            <h5 class="card-title mb-3">Upload Photos</h5>
                            
                            <div class="dropzone-area rounded-3 border-2 border-dashed p-4 mb-3" id="dropzone">
                                <!-- Upload Icon -->
                                <div class="dropzone-icon d-flex justify-content-center mb-2">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" 
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="17 8 12 3 7 8"></polyline>
                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                    </svg>
                                </div>
                                
                                <!-- Upload Text -->
                                <p class="dropzone-text mb-2">Drop media here</p>
                                <p class="text-muted small mb-0">or click to browse files</p>
                                
                                <!-- Hidden File Input -->
                                <input type="file" id="photoUpload" name="photo" accept="image/*" class="d-none">
                            </div>
                            
                            <!-- Upload Info -->
                            <div class="upload-info">
                                <p class="text-muted small mb-2">
                                    Max file size: 5MB. Supported: JPG, PNG, JPEG
                                </p>
                                <div id="uploadProgress" class="progress mb-2 d-none">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <div id="uploadStatus"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photos -->
                @forelse($user->photos as $photo)
                    <div class="col-md-4 col-lg-3 mb-3">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                class="img-fluid rounded shadow-sm">
                            <!-- Delete button -->
                            <form action="{{ route('model.photos.delete', $photo->id) }}" method="POST" 
                                class="position-absolute top-0 end-0 m-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Delete this photo?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>                    
                @empty
                    <div class="col-12">
                        <p class="text-muted text-center">No photos uploaded yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Videos -->
        <div class="tab-pane fade" id="videos" role="tabpanel">
            <div class="row">
                <!-- Upload Card -->
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card mb-4">
                        <div class="card-body text-center p-4">
                            <h5 class="card-title mb-3">Upload Videos</h5>

                            <!-- Dropzone -->
                            <div class="dropzone-area rounded-3 border-2 border-dashed p-4 mb-3" id="videoDropzone">
                                <!-- Upload Icon -->
                                <div class="dropzone-icon d-flex justify-content-center mb-2">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" 
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="17 8 12 3 7 8"></polyline>
                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                    </svg>
                                </div>

                                <p class="dropzone-text mb-2">Drop video here</p>
                                <p class="text-muted small mb-2">or click to browse files</p>

                                <!-- Hidden File Input -->
                                <input type="file" id="videoUpload" name="video" 
                                    accept="video/mp4,video/x-m4v,video/*" class="d-none">
                            </div>


                            <!-- Upload Info -->
                            <div class="upload-info mb-2">
                                <p class="text-muted small mb-2">
                                    Max file size: 50MB. Supported: MP4, M4V
                                </p>
                                <div id="videoUploadProgress" class="progress mb-2 d-none">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <div id="videoUploadStatus"></div>
                            </div>
                            <!-- Button to open modal -->
                            <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#youtubeModal">
                                or Add Youtube Link
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Display Uploaded Videos -->
                @forelse($user->videos as $video)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="position-relative">
                            @if($video->file_path)
                                <video controls class="w-100 rounded shadow-sm">
                                    <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                                </video>
                            @elseif($video->youtube_url)
                                <iframe class="w-100 rounded shadow-sm" height="250" 
                                    src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::after($video->youtube_url, 'v=') }}" 
                                    frameborder="0" allowfullscreen></iframe>
                            @endif

                            <!-- Delete Button -->
                            <form action="{{ route('model.videos.delete', $video->id) }}" method="POST" 
                                class="position-absolute top-0 end-0 m-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Delete this video?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted text-center">No videos uploaded yet.</p>
                    </div>
                @endforelse
            </div>
        </div>


        <!-- TikTok (reuse videos/links if needed) -->
        <div class="d-flex justify-content-center gap-3 mt-2">
            @if($user->linkedAccounts && $user->linkedAccounts->instagram_url)
                <a href="{{ $user->linkedAccounts->instagram_url }}" target="_blank">
                    <i class="bx bxl-instagram"></i>
                </a>
            @endif

            @if($user->linkedAccounts && $user->linkedAccounts->twitter_url)
                <a href="{{ $user->linkedAccounts->twitter_url }}" target="_blank">
                    <i class="bx bxl-twitter"></i>
                </a>
            @endif

            @if($user->linkedAccounts && $user->linkedAccounts->tiktok_url)
                <a href="{{ $user->linkedAccounts->tiktok_url }}" target="_blank">
                    <i class="bx bxl-tiktok"></i>
                </a>
            @endif
        </div>

        <div class="tab-pane fade container d-flex justify-content-center" id="tiktok" role="tabpanel">
            <div class="col-md-8"> <!-- Centered block with max width -->
                {{-- @if($user->linkedAccount && $user->linkedAccount->tiktok_url)
                    <div class="ratio ratio-16x9 mb-3">
                        <iframe src="{{ $user->linkedAccount->tiktok_url }}" 
                            style="border:none;overflow:hidden" 
                            scrolling="no" allowfullscreen></iframe>
                    </div>
                @else --}}
                    <div class="col-12 alert alert-danger">
                        <p class="text-dark text-center" style="font-size: 15px">Coming Soon.</p>
                    </div>
                {{-- @endif --}}
            </div>
        </div>


        <!-- About -->
        <div class="tab-pane fade container d-flex justify-content-center" id="about" role="tabpanel">
            <div class="col-md-8"> <!-- Centered block with max width -->

                <!-- Profile info in 2-column grid -->
                <div class="row row-cols-1 row-cols-md-2 g-3 mb-3">
                    <div class="col">
                        <p><span class="text-muted">Age:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $user->publicInfo->age ?? '-' }}</strong></p>
                    </div>
                    <div class="col">
                        <p><span class="text-muted">Gender:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $user->publicInfo->gender ?? '-' }}</strong></p>
                    </div>
                    <div class="col">
                        <p><span class="text-muted">Ethnicity:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $user->publicInfo->ethnicity ?? '-' }}</strong></p>
                    </div>
                    <div class="col">
                        <p><span class="text-muted">Height:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $user->publicInfo->height ?? '-' }}</strong></p>
                    </div>
                    <div class="col">
                        <p><span class="text-muted">Hair:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $user->publicInfo->hair ?? '-' }}</strong></p>
                    </div>
                    <div class="col">
                        <p><span class="text-muted">Eye:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $user->publicInfo->eye ?? '-' }}</strong></p>
                    </div>
                    <div class="col">
                        <p><span class="text-muted">Shoes:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $user->publicInfo->shoes ?? '-' }}</strong></p>
                    </div>
                    <div class="col">
                        <p><span class="text-muted">Waist:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $user->publicInfo->waist ?? '-' }}</strong></p>
                    </div>
                    <div class="col">
                        <p><span class="text-muted">Hips:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $user->publicInfo->hips ?? '-' }}</strong></p>
                    </div>
                    <div class="col">
                        <p><span class="text-muted">Location:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $user->publicInfo->location ?? '-' }}</strong></p>
                    </div>
                    <div class="col">
                        <p><span class="text-muted">Nationality:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $user->publicInfo->nationality ?? '-' }}</strong></p>
                    </div>
                </div>

                <br/>
                <!-- Languages -->
                <div class="mb-3">
                    <p class="text-muted mb-1">Languages:</p>
                    <p><strong>{{ $user->publicInfo->languages ?? '-' }}</strong></p>
                </div>

                <!-- About me -->
                <div class="mb-3">
                    <p class="text-muted mb-1">About me:</p>
                    <p>
                        @if(!empty($user->publicInfo->about_me))
                            {{ $user->publicInfo->about_me }}
                        @else
                            You have not added an About text yet
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal popup-->
<!-- YouTube/Vimeo URL Modal -->
<div class="modal fade" id="youtubeModal" tabindex="-1" aria-labelledby="youtubeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="youtubeModalLabel">Add YouTube Link</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('model.videos.storeLink') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="youtube_url" class="form-label">Video URL</label>
            <input type="url" name="youtube_url" id="youtube_url" class="form-control" 
                   placeholder="https://youtube.com/watch?v=..." required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Link</button>
        </div>
      </form>

    </div>
  </div>
</div>
<script>
/** Auto-select tab from URL param */
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get("tab");

    if (tab) {
        // Find the corresponding nav link
        const tabTrigger = document.querySelector(`#${tab}-tab`);
        if (tabTrigger) {
            // Use Bootstrap's Tab API to show it
            const bsTab = new bootstrap.Tab(tabTrigger);
            bsTab.show();
        }
    }
});

/**Image Uploads*/
document.addEventListener('DOMContentLoaded', function() {
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('photoUpload');
    const progressBar = document.querySelector('.progress-bar');
    const progressContainer = document.getElementById('uploadProgress');
    const uploadStatus = document.getElementById('uploadStatus');

    let isUploading = false;

    // Click to select files
    dropzone.addEventListener('click', function(e) {
        if (!isUploading) {
            fileInput.click();
        }
    });

    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        if (!isUploading) {
            dropzone.classList.add('dragover');
        }
    }

    function unhighlight() {
        dropzone.classList.remove('dragover');
    }

    // Handle file drop
    dropzone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        if (isUploading) return;
        
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length > 0) {
            handleFile(files[0]); // Only process the first file
        }
    }

    // Handle file selection
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0 && !isUploading) {
            handleFile(this.files[0]); // Only process the first file
            this.value = ''; // Reset input
        }
    });

    function handleFile(file) {
        // Validate file type and size
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!validTypes.includes(file.type)) {
            showStatus('Please select a valid image file (JPG, PNG, JPEG).', 'error');
            return;
        }

        if (file.size > maxSize) {
            showStatus('File size must be less than 5MB.', 'error');
            return;
        }

        // Show progress bar
        isUploading = true;
        dropzone.style.opacity = '0.7';
        dropzone.style.cursor = 'not-allowed';
        progressContainer.classList.remove('d-none');
        progressBar.style.width = '0%';
        progressBar.classList.remove('bg-success');

        // Create FormData
        const formData = new FormData();
        formData.append('photo', file);
        formData.append('_token', '{{ csrf_token() }}');

        // Send AJAX request
        const xhr = new XMLHttpRequest();

        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                progressBar.style.width = percentComplete + '%';
                
                // Change color when complete
                if (percentComplete === 100) {
                    progressBar.classList.add('bg-success');
                }
            }
        });

        xhr.addEventListener('load', function() {
            isUploading = false;
            dropzone.style.opacity = '1';
            dropzone.style.cursor = 'pointer';
            
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        showStatus('Photo uploaded successfully!', 'success');
                        // Reload page after 1 second to show new photo
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showStatus('Upload failed: ' + response.message, 'error');
                    }
                } catch (e) {
                    showStatus('Error parsing response.', 'error');
                }
            } else {
                showStatus('Error uploading photo. Please try again.', 'error');
            }
        });

        xhr.addEventListener('error', function() {
            isUploading = false;
            dropzone.style.opacity = '1';
            dropzone.style.cursor = 'pointer';
            showStatus('Network error. Please try again.', 'error');
        });

        xhr.open('POST', '{{ route("model.photos.upload") }}', true);
        xhr.send(formData);
    }

    function showStatus(message, type) {
        uploadStatus.innerHTML = `
            <div class="alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }
});

/**Video Uploads*/
document.addEventListener("DOMContentLoaded", function() {
    const videoDropzone = document.getElementById("videoDropzone");
    const videoUploadInput = document.getElementById("videoUpload");
    const progressBar = document.querySelector("#videoUploadProgress .progress-bar");
    const progressWrapper = document.getElementById("videoUploadProgress");
    const uploadStatus = document.getElementById("videoUploadStatus");

    // Click dropzone to open file dialog
    videoDropzone.addEventListener("click", () => videoUploadInput.click());

    // Handle file select
    videoUploadInput.addEventListener("change", function() {
        if (this.files.length > 0) {
            uploadVideo(this.files[0]);
        }
    });

    // Handle drag & drop
    videoDropzone.addEventListener("dragover", (e) => {
        e.preventDefault();
        videoDropzone.classList.add("bg-light");
    });

    videoDropzone.addEventListener("dragleave", () => {
        videoDropzone.classList.remove("bg-light");
    });

    videoDropzone.addEventListener("drop", (e) => {
        e.preventDefault();
        videoDropzone.classList.remove("bg-light");
        if (e.dataTransfer.files.length > 0) {
            uploadVideo(e.dataTransfer.files[0]);
        }
    });

    function uploadVideo(file) {
        const formData = new FormData();
        formData.append("video", file);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "{{ route('model.videos.upload') }}", true);
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

        // Progress
        xhr.upload.addEventListener("progress", function(e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressWrapper.classList.remove("d-none");
                progressBar.style.width = percent + "%";
                progressBar.innerText = percent + "%";
            }
        });

        // Done
        xhr.onload = function() {
            if (xhr.status === 200) {
                uploadStatus.innerHTML = '<span class="text-success">Upload complete!</span>';
                location.reload(); // reload to show new video
            } else {
                uploadStatus.innerHTML = '<span class="text-danger">Upload failed.</span>';
            }
        };

        xhr.send(formData);
    }
});
</script>
@endsection
