@extends('layouts.gallery')

@section('content')
@php
    $isOwner = Auth::check() && Auth::id() === $user->id;
    $displayName = $user->publicInfo?->display_name ?? $user->name;
    $avatarUrl = $user->publicInfo?->profile_picture
        ? asset('storage/' . $user->publicInfo->profile_picture)
        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=160';
@endphp

<div class="container model-profile pb-5">
    <div class="model-profile__header">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 gap-md-4">
                    <img src="{{ $avatarUrl }}"
                        alt="{{ $displayName }}"
                        class="model-profile__avatar rounded-circle"
                        width="120" height="120">
                    <div>
                        <h1 class="model-profile__name mb-1">{{ $displayName }}</h1>
                        @if($user->user_type)
                            <span class="badge model-profile__badge">{{ $user->user_type }}</span>
                        @endif
                        <p class="model-profile__location mb-0 mt-2">
                            <i class="bi bi-geo-alt-fill me-1"></i>
                            {{ $user->publicInfo?->location ?? 'Location not set' }}
                        </p>
                    </div>
                </div>
            </div>

            @if($isOwner)
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                        My dashboard
                    </a>
                </div>
            @else
                <div class="col-lg-4">
                    <div class="model-profile__actions d-flex flex-wrap gap-2 justify-content-lg-end">
                        @auth
                            <button type="button" id="follow-btn"
                                class="btn btn-sm rounded-pill {{ ($isFollowing ?? false) ? 'btn-outline-secondary' : 'btn-primary' }}"
                                data-model-id="{{ $user->id }}"
                                data-following="{{ ($isFollowing ?? false) ? '1' : '0' }}">
                                <i class="bi bi-person-{{ ($isFollowing ?? false) ? 'check-' : '' }}plus"></i>
                                {{ ($isFollowing ?? false) ? 'Following' : 'Follow' }}
                            </button>
                            <a href="{{ route('account.messages.show', $user) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                <i class="bi bi-chat-dots"></i> Message
                            </a>
                            <a href="{{ route('account.bookings.create', $user) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                <i class="bi bi-calendar-plus"></i> Book
                            </a>
                        @endauth
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill">Log in to connect</a>
                        @endguest
                    </div>
                </div>
            @endif
        </div>

        <div class="model-profile__stats">
            <div class="model-stat">
                <span class="model-stat__label">@if($isOwner) Photo loves @else Likes @endif</span>
                <strong class="model-stat__value">{{ $stats['photo_likes'] }}</strong>
            </div>
            <div class="model-stat">
                <span class="model-stat__label">Photo views</span>
                <strong class="model-stat__value">{{ $stats['photo_views'] }}</strong>
            </div>
            <div class="model-stat">
                <span class="model-stat__label">@if($isOwner) Video loves @else Likes @endif</span>
                <strong class="model-stat__value">{{ $stats['video_likes'] }}</strong>
            </div>
            <div class="model-stat">
                <span class="model-stat__label">Video views</span>
                <strong class="model-stat__value">{{ $stats['video_views'] }}</strong>
            </div>
            <div class="model-stat">
                <span class="model-stat__label">Followers</span>
                <strong class="model-stat__value" id="followers-count">{{ $stats['followers'] }}</strong>
            </div>
            <div class="model-stat">
                <span class="model-stat__label">Last login</span>
                <strong class="model-stat__value model-stat__value--small">
                    {{ $user->last_login ? ($user->last_login->copy()->addHours(3)->isToday()
                        ? 'Today ' . $user->last_login->copy()->addHours(3)->format('h:i A')
                        : $user->last_login->copy()->addHours(3)->format('M d, Y')) : 'Never' }}
                </strong>
            </div>
        </div>

        @if($user->linkedAccount && ($user->linkedAccount->instagram_url || $user->linkedAccount->twitter_url || $user->linkedAccount->tiktok_url || $user->linkedAccount->youtube_url || $user->linkedAccount->other_url))
            <div class="model-profile__social">
                @if($user->linkedAccount->instagram_url)
                    <a href="{{ $user->linkedAccount->instagram_url }}" target="_blank" rel="noopener" class="model-social-link" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                @endif
                @if($user->linkedAccount->twitter_url)
                    <a href="{{ $user->linkedAccount->twitter_url }}" target="_blank" rel="noopener" class="model-social-link" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                @endif
                @if($user->linkedAccount->tiktok_url)
                    <a href="{{ $user->linkedAccount->tiktok_url }}" target="_blank" rel="noopener" class="model-social-link" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                @endif
                @if($user->linkedAccount->youtube_url)
                    <a href="{{ $user->linkedAccount->youtube_url }}" target="_blank" rel="noopener" class="model-social-link" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                @endif
                @if($user->linkedAccount->other_url)
                    <a href="{{ $user->linkedAccount->other_url }}" target="_blank" rel="noopener" class="model-social-link" aria-label="Website"><i class="bi bi-globe"></i></a>
                @endif
            </div>
        @endif
    </div>

    <ul class="nav model-profile-tabs" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="photos-tab" data-bs-toggle="tab" href="#photos" role="tab">Photos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="videos-tab" data-bs-toggle="tab" href="#videos" role="tab">Videos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tiktok-tab" data-bs-toggle="tab" href="#tiktok" role="tab">TikTok</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="about-tab" data-bs-toggle="tab" href="#about" role="tab">About</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab">
                Reviews
                @if(($reviewStats['count'] ?? 0) > 0)
                    ({{ $reviewStats['count'] }})
                @endif
            </a>
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
                        <div class="model-profile-photo">
                            <img src="{{ asset('storage/' . $photo->file_path) }}"
                                class="model-profile-photo__image"
                                alt="Photo by {{ $displayName }}">
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
                    <div class="col-md-8 col-12">
                        <p class="text-muted text-center">
                            @if($isOwner)
                                <br/>
                               <b>No photos uploaded yet. Upload your first photo to get started!</b>
                            @else
                                <br/>
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
                    <div class="col-md-8 col-12">
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
                @if($user->linkedAccount?->hasTikTokConnection())
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
            <div class="model-about-panel">
                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-4">
                    @php
                    $fields = [
                        'Age' => $user->publicInfo?->age ?? '-',
                        'Gender' => $user->publicInfo?->gender ?? '-',
                        'Ethnicity' => $user->publicInfo?->ethnicity ?? '-',
                        'Height' => $user->publicInfo?->height ?? '-',
                        'Hair' => $user->publicInfo?->hair ?? '-',
                        'Eye' => $user->publicInfo?->eye ?? '-',
                        'Shoes' => $user->publicInfo?->shoes ?? '-',
                        'Waist' => $user->publicInfo?->waist ?? '-',
                        'Hips' => $user->publicInfo?->hips ?? '-',
                        'Location' => $user->publicInfo?->location ?? '-',
                        'Nationality' => $user->publicInfo?->nationality ?? '-',
                    ];
                    @endphp

                    @foreach ($fields as $label => $value)
                        <div class="col">
                            <div class="model-about-field">
                                <span class="model-about-field__label">{{ $label }}</span>
                                <strong class="model-about-field__value">{{ $value }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mb-4">
                    <p class="model-about-field__label mb-1">Languages</p>
                    <p class="mb-0"><strong>{{ $user->publicInfo?->languages ?? '-' }}</strong></p>
                </div>

                <div>
                    <p class="model-about-field__label mb-2">
                        @if($isOwner) About me @else About {{ $displayName }} @endif
                    </p>
                    <p class="model-about-bio mb-0">
                        @if(!empty($user->publicInfo?->about_me))
                            {{ $user->publicInfo->about_me }}
                        @else
                            @if($isOwner)
                                You have not added an about section yet. <a href="{{ route('account.public.edit') }}">Update your profile</a>.
                            @else
                                No about information available.
                            @endif
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Reviews -->
        <div class="tab-pane fade" id="reviews" role="tabpanel">
            <div class="model-about-panel">
                @if(($reviewStats['average'] ?? null))
                    <div class="text-center mb-4 pb-3 border-bottom">
                        <div class="account-rating-display">
                            <span class="account-rating-display__value">{{ $reviewStats['average'] }}</span>
                            <div class="account-stars justify-content-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= round($reviewStats['average']) ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                            <p class="text-muted small mb-0">{{ $reviewStats['count'] }} {{ Str::plural('review', $reviewStats['count']) }}</p>
                        </div>
                    </div>
                @endif

                @forelse($reviews ?? [] as $review)
                    <div class="account-review-card mb-3 pb-3 border-bottom">
                        <div class="d-flex gap-3">
                            <img src="{{ $review->reviewer->avatarUrl(64) }}" alt="" class="rounded-circle" width="44" height="44">
                            <div>
                                <div class="d-flex flex-wrap gap-2 align-items-center mb-1">
                                    <strong>{{ $review->reviewer->displayName() }}</strong>
                                    <span class="text-muted small">{{ $review->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="account-stars account-stars--sm mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                @if($review->comment)
                                    <p class="small mb-0">{{ $review->comment }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-3 mb-0">No reviews yet.</p>
                @endforelse

                @auth
                    @if(!$isOwner)
                        <div class="mt-4 pt-3 border-top">
                            <h3 class="h6 fw-bold mb-3">{{ $userReview ? 'Update your review' : 'Leave a review' }}</h3>
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <form action="{{ route('models.reviews.store', $user) }}" method="POST">
                                @csrf
                                <div class="auth-form__group">
                                    <label class="form-label">Rating</label>
                                    <select name="rating" required class="form-select auth-form__control">
                                        @for($i = 5; $i >= 1; $i--)
                                            <option value="{{ $i }}" @selected(old('rating', $userReview?->rating) == $i)>
                                                {{ $i }} {{ Str::plural('star', $i) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="auth-form__group">
                                    <label class="form-label">Comment <span class="text-muted fw-normal">(optional)</span></label>
                                    <textarea name="comment" rows="3" class="form-control auth-form__control"
                                        placeholder="Share your experience working with {{ $displayName }}...">{{ old('comment', $userReview?->comment) }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">{{ $userReview ? 'Update review' : 'Submit review' }}</button>
                            </form>
                        </div>
                    @endif
                @endauth
                @guest
                    <p class="text-center mt-4 mb-0">
                        <a href="{{ route('login') }}">Log in</a> to leave a review.
                    </p>
                @endguest
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
    const container = document.getElementById('tiktok-videos-container');
    if (!container) {
        return;
    }

    const tiktokTab = document.getElementById('tiktok-tab');
    if (tiktokTab) {
        tiktokTab.addEventListener('shown.bs.tab', function() {
            loadTikTokVideos();
        });
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('tab') === 'tiktok') {
        setTimeout(loadTikTokVideos, 500);
    }
});

function loadTikTokVideos() {
    const container = document.getElementById('tiktok-videos-container');
    if (!container) {
        return;
    }

    fetch('{{ route("tiktok.videos") }}', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.connected === false) {
                showTikTokNotConnectedMessage(container);
                return;
            }

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

function showTikTokNotConnectedMessage(container) {
    container.innerHTML = `
        <div class="col-12 text-center py-5">
            <div class="alert alert-info mb-0">
                <h5 class="h6 fw-bold">TikTok not connected</h5>
                <p class="mb-0">Connect your TikTok account to display videos here.</p>
            </div>
        </div>
    `;
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

// Follow button
document.addEventListener('DOMContentLoaded', function() {
    const followBtn = document.getElementById('follow-btn');
    if (!followBtn) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const modelId = followBtn.dataset.modelId;

    followBtn.addEventListener('click', function() {
        const isFollowing = followBtn.dataset.following === '1';
        const url = `/models/${modelId}/follow`;
        const method = isFollowing ? 'DELETE' : 'POST';

        fetch(url, {
            method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
            .then(res => {
                if (res.status === 401) {
                    window.location.href = '{{ route('login') }}';
                    return null;
                }
                return res.json();
            })
            .then(data => {
                if (!data) return;

                const nowFollowing = !isFollowing;
                followBtn.dataset.following = nowFollowing ? '1' : '0';
                followBtn.classList.toggle('btn-primary', !nowFollowing);
                followBtn.classList.toggle('btn-outline-secondary', nowFollowing);
                followBtn.innerHTML = nowFollowing
                    ? '<i class="bi bi-person-check"></i> Following'
                    : '<i class="bi bi-person-plus"></i> Follow';

                const countEl = document.getElementById('followers-count');
                if (countEl && data.followers_count !== undefined) {
                    countEl.textContent = data.followers_count;
                }
            })
            .catch(err => console.error('Follow error:', err));
    });
});

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
