@extends('layouts.app')

@section('title', 'Linked Accounts')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/account" class="fw-semibold text-dark h5 m-0">
                    {{ __('Account') }}
                </a>
            </li>
            <li class="breadcrumb-item active fw-semibold text-dark h5 m-0" aria-current="page">
                {{ __('Linked accounts') }}
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Linked accounts</h5>
                </div>
                <div class="card-body">
                    
                    <!-- TikTok Connection -->
                    <div class="mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-dark rounded-circle p-2 me-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="mb-0">TikTok</h6>
                                    <p class="text-muted mb-0">Connect your TikTok account to display videos</p>
                                </div>
                            </div>
                           <div>
                            @if($linkedAccount->tiktok_connected)
                                <span class="badge bg-success me-2">Connected</span>

                                <!-- Disconnect Button -->
                                <form action="{{ route('tiktok.disconnect') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to disconnect your TikTok account?');">
                                        Disconnect
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('tiktok.connect') }}" class="btn btn-outline-dark btn-sm">
                                    Connect TikTok
                                </a>
                            @endif
                        </div>

                        </div>
                        @if($linkedAccount->tiktok_connected)
                            <p class="text-success mb-0">
                                <small>✓ Your TikTok feed will display in your profile</small>
                            </p>
                        @endif
                    </div>

                    <!-- Other Social Networks Form -->
                    <form action="{{ route('account.linked.update') }}" method="POST">
                        @csrf
                        
                        <!-- Instagram -->
                        <div class="mb-3">
                            <label class="form-label">Instagram URL</label>
                            <input type="url" name="instagram_url" 
                                value="{{ old('instagram_url', $linkedAccount->instagram_url) }}"
                                placeholder="https://www.instagram.com/yourusername"
                                class="form-control @error('instagram_url') is-invalid @enderror">
                            @error('instagram_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Twitter -->
                        <div class="mb-3">
                            <label class="form-label">Twitter URL</label>
                            <input type="url" name="twitter_url" 
                                   value="{{ old('twitter_url', $linkedAccount->twitter_url) }}"
                                   placeholder="https://www.twitter.com/yourusername"
                                   class="form-control @error('twitter_url') is-invalid @enderror">
                            @error('twitter_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- YouTube -->
                        <div class="mb-3">
                            <label class="form-label">YouTube URL</label>
                            <input type="url" name="youtube_url" 
                                   value="{{ old('youtube_url', $linkedAccount->youtube_url) }}"
                                   placeholder="https://www.youtube.com/yourchannel"
                                   class="form-control @error('youtube_url') is-invalid @enderror" >
                            @error('youtube_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Other Websites -->
                        <div class="mb-3">
                            <label class="form-label">Websites</label>
                            <input type="url" name="other_url" 
                                   value="{{ old('other_url', $linkedAccount->other_url) }}"
                                   placeholder="https://example.com"
                                   class="form-control @error('other_url') is-invalid @enderror">
                            @error('other_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="form-text">Add any other social media profile or personal website</div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Save URLs</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
