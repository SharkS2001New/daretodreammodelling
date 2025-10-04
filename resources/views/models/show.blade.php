@extends('layouts.gallery')

@section('content')
@php
    $isOwner = Auth::check() && Auth::id() === $user->id;
@endphp

<div class="container">
    <div class="profile-header text-left mb-4">
        <div class="row align-items-center mb-4">
            <!-- Left: Profile Info -->
            <div class="col d-flex align-items-center mb-3">
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

            <!-- Right: Modelling Page Button (Only for owner) -->
            @if($isOwner)
            <div class="col-auto text-end">
                <a href="/dashboard" class="btn btn-outline-primary btn-sm">
                    View My Modelling Dashboard
                </a>
            </div>
            @endif
        </div>

        <div class="stats d-flex justify-content-center flex-wrap gap-4 my-3 text-muted small">
            <div>
                @if($isOwner)Photo loves @else Likes @endif: 
                <strong>{{ $stats['photo_likes'] }}</strong>
            </div>
            <div>
                Photo Views: <strong>{{ $stats['photo_views'] }}</strong>
            </div>
            <div>
                @if($isOwner)Video loves @else Likes @endif: 
                <strong>{{ $stats['video_likes'] }}</strong>
            </div>
            <div>
                Video Views: <strong>{{ $stats['video_views'] }}</strong>
            </div>
            <div>
                Followers: <strong>{{ $stats['followers'] }}</strong>
            </div>

            <!-- Force break only on mobile -->
            <div class="w-100 d-block d-md-none"></div>

            {{-- @if($isOwner) --}}
            <div>
                Last login:
                <strong>
                    {{ $user->last_login ? ($user->last_login->copy()->addHours(3)->isToday() 
                        ? 'Today ' . $user->last_login->copy()->addHours(3)->format('h:i A') 
                        : $user->last_login->copy()->addHours(3)->format('M d, Y h:i A')) 
                        : 'Never' }}
                </strong>
            </div>
            {{-- @endif --}}
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
    <ul class="nav nav-tabs justify-content-center flex-nowrap overflow-auto text-nowrap border-0" id="profileTabs" role="tablist" style="white-space: nowrap;">
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
                <!-- Upload Card (only for owner) -->
                @if($isOwner)
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
                @endif

                <!-- Photos -->
                @forelse($user->photos as $photo)
                    <div class="col-md-4 col-lg-3 col-6 mb-3">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                class="img-fluid rounded shadow-sm">
                            <!-- Delete button (only for owner) -->
                            @if($isOwner)
                            <form action="{{ route('model.photos.delete', $photo->id) }}" method="POST" 
                                class="position-absolute top-0 end-0 m-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Delete this photo?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>                    
                @empty
                    <div class="col-12">
                        <p class="text-muted text-center">
                            @if($isOwner)
                               <b>No photos uploaded yet. Upload your first photo to get started!</b>
                            @else
                                <b>No photos available yet.</b>
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Videos -->
        <div class="tab-pane fade" id="videos" role="tabpanel">
            <div class="row">
                <!-- Upload Card (only for owner) -->
                @if($isOwner)
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
                                    Max file size: 20MB. Supported: MP4, M4V
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
                @endif

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

                            <!-- Delete Button (only for owner) -->
                            @if($isOwner)
                            <form action="{{ route('model.videos.delete', $video->id) }}" method="POST" 
                                class="position-absolute top-0 end-0 m-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Delete this video?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <p class="text-muted text-center">
                            @if($isOwner)
                                <br/>
                                <b>No videos uploaded yet. Upload your first video or add a YouTube link!</b>
                            @else
                                <br/>
                                <b>No videos available yet.</b>
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- TikTok Tab -->
        <div class="tab-pane fade" id="tiktok" role="tabpanel">
            <div class="container">
                @if($user->linkedAccount && $user->linkedAccount->tiktok_connected)
                    <div class="text-center py-2">
                        <div class="alert alert-success">
                            <h5><i class="bi bi-tiktok"></i> 
                                @if($isOwner)
                                    Your TikTok Account
                                @else
                                    TikTok
                                @endif
                                Connected
                            </h5>
                            <p class="mb-0">Click any video to play it in a popup</p>

                            <!-- Disconnect Button (only for owner) -->
                            @if($isOwner)
                            <form action="{{ route('tiktok.disconnect') }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-x-circle"></i> Disconnect TikTok Account
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    
                    <!-- TikTok Videos Container -->
                    <div class="row" id="tiktok-videos-container">
                        <div class="col-12 text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading TikTok videos...</span>
                            </div>
                            <p class="mt-2 text-muted">Loading TikTok videos...</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-2">
                        <div class="alert alert-info">
                            <h5><i class="bi bi-tiktok"></i> 
                                @if($isOwner)
                                    Connect Your TikTok
                                @else
                                    TikTok
                                @endif
                            </h5>
                            <p class="mb-3">
                                @if($isOwner)
                                    Connect your TikTok account to display your videos here.
                                @else
                                    TikTok account not connected.
                                @endif
                            </p>
                            @if($isOwner)
                            <a href="{{ route('tiktok.connect') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Connect TikTok Account
                            </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- About -->
        <div class="tab-pane fade" id="about" role="tabpanel">
            <div class="container py-4 d-flex justify-content-center">
                <div class="col-md-8">
                <!-- Profile info in 2-column grid -->
                <div class="row row-cols-1 row-cols-md-2 g-3 mb-3">
                    @php
                    $fields = [
                        'Age' => $user->publicInfo->age ?? '-',
                        'Gender' => $user->publicInfo->gender ?? '-',
                        'Ethnicity' => $user->publicInfo->ethnicity ?? '-',
                        'Height' => $user->publicInfo->height ?? '-',
                        'Hair' => $user->publicInfo->hair ?? '-',
                        'Eye' => $user->publicInfo->eye ?? '-',
                        'Shoes' => $user->publicInfo->shoes ?? '-',
                        'Waist' => $user->publicInfo->waist ?? '-',
                        'Hips' => $user->publicInfo->hips ?? '-',
                        'Location' => $user->publicInfo->location ?? '-',
                        'Nationality' => $user->publicInfo->nationality ?? '-',
                    ];
                    @endphp

                    @foreach ($fields as $label => $value)
                    <div class="col">
                        <div class="d-flex justify-content-between pb-1">
                        <span class="text-muted">{{ $label }}:</span>
                        <strong>{{ $value }}</strong>
                        </div>
                    </div>
                    @endforeach
                </div>

                <br/>

                <!-- Languages -->
                <div class="mb-3"> 
                    <p class="text-muted mb-1">Languages:</p>
                    <p><strong>{{ $user->publicInfo->languages ?? '-' }}</strong></p> 
                </div>

                <!-- About me -->
                <div class="mb-3">
                    <p class="text-muted mb-1">
                    @if($isOwner)
                        About me:
                    @else
                        About {{ $user->publicInfo?->display_name ?? $user->name }}:
                    @endif
                    </p>
                    <p>
                    @if(!empty($user->publicInfo->about_me))
                        {{ $user->publicInfo->about_me }}
                    @else
                        @if($isOwner)
                        You have not added an About text yet
                        @else
                        No about information available.
                        @endif
                    @endif
                    </p>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal popups (only show YouTube modal for owners) -->
@if($isOwner)
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
@endif

<!-- TikTok Video Popup Modal (available for all viewers) -->
<div class="modal fade" id="tiktokVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center">
                <div id="tiktok-video-player" class="w-100"></div>
            </div>
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

// TikTok Tab Loading
document.addEventListener('DOMContentLoaded', function() {
    const tiktokTab = document.getElementById('tiktok-tab');
    
    tiktokTab.addEventListener('shown.bs.tab', function() {
        loadTikTokVideos();
    });

    // Load videos immediately if TikTok tab is active
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');
    if (activeTab === 'tiktok') {
        setTimeout(loadTikTokVideos, 500);
    }
});

function loadTikTokVideos() {
    const container = document.getElementById('tiktok-videos-container');

    fetch('{{ route("tiktok.videos") }}')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load TikTok videos');
            }
            return response.json();
        })
        .then(data => {
            if (data.data && data.data.videos && data.data.videos.length > 0) {
                renderTikTokVideos(data.data.videos);
            } else {
                showNoVideosMessage(container);
            }
        })
        .catch(err => {
            console.error('TikTok error:', err);
            showNoVideosMessage(container);
        });
}

function renderTikTokVideos(videos) {
    const container = document.getElementById('tiktok-videos-container');
    container.innerHTML = '';

    videos.forEach(video => {
        const col = document.createElement("div");
        col.className = "col-md-4 col-lg-3 mb-4";
        
        const coverImage = video.cover_image_url || 'https://via.placeholder.com/300x400/000000/FFFFFF?text=No+Preview';
        const title = video.title || 'TikTok Video';
        const shareUrl = video.share_url || '#';

        col.innerHTML = `
            <div class="card video-card shadow-sm border-0 h-100">
                <div class="position-relative">
                    <img src="${coverImage}" 
                         class="card-img-top" 
                         alt="${title}"
                         style="height: 250px; object-fit: cover; cursor: pointer;"
                         onclick="playTikTokVideo('${shareUrl}', '${title.replace(/'/g, "\\'")}')">
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-dark bg-opacity-75">
                            <i class="bi bi-play-fill"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="card-title text-truncate" title="${title}">${title}</h6>
                    <button class="btn btn-primary btn-sm w-100" 
                            onclick="playTikTokVideo('${shareUrl}', '${title.replace(/'/g, "\\'")}')">
                        <i class="bi bi-play-circle"></i> Play Video
                    </button>
                </div>
            </div>
        `;

        container.appendChild(col);
    });
}

function showNoVideosMessage(container) {
    container.innerHTML = `
        <div class="col-12 text-center py-5">
            <div class="alert alert-info">
                <h5>No TikTok Videos Found</h5>
                <p>No videos were found in your TikTok account.</p>
            </div>
        </div>
    `;
}

function playTikTokVideo(videoUrl, title = 'TikTok Video') {
    if (!videoUrl || videoUrl === '#') {
        alert('Video URL not available');
        return;
    }

    const modal = new bootstrap.Modal(document.getElementById('tiktokVideoModal'));
    const player = document.getElementById('tiktok-video-player');

    // Clear previous content
    player.innerHTML = '';

    // Create TikTok embed with proper styling for mobile
    const embedHtml = `
        <blockquote class="tiktok-embed" 
                    cite="${videoUrl}" 
                    data-video-id="${getVideoIdFromUrl(videoUrl)}" 
                    style="max-width: 325px; min-width: 325px; margin: 0 auto;">
            <section></section>
        </blockquote>
    `;

    player.innerHTML = embedHtml;

    // Load TikTok embed script
    loadTikTokEmbedScript();

    // Show modal
    modal.show();
}

function getVideoIdFromUrl(url) {
    // Extract video ID from TikTok URL
    const match = url.match(/\/video\/(\d+)/);
    return match ? match[1] : '';
}

function loadTikTokEmbedScript() {
    // Remove existing script to force reload
    const existingScript = document.querySelector('script[src="https://www.tiktok.com/embed.js"]');
    if (existingScript) {
        existingScript.remove();
    }

    // Create new script
    const script = document.createElement('script');
    script.src = 'https://www.tiktok.com/embed.js';
    document.body.appendChild(script);
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('tiktokVideoModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                const bsModal = bootstrap.Modal.getInstance(modal);
                bsModal.hide();
            }
        });
    }
});
</script>
@endsection
