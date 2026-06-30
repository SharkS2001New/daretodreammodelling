<aside id="layout-menu" class="menu-sidebar">
    <!-- Profile Section -->
    <div class="profile">
        <div class="profile-container">
            <div class="profile-pic">
                <img src="{{ $publicInfo && $publicInfo->profile_picture 
                                ? asset('storage/'.$publicInfo->profile_picture) 
                                : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&size=150' }}" 
                    alt="Profile Picture"
                    class="rounded-circle object-fit-cover border"
                    width="150"
                    height="150">
            </div>
            <div class="profile-info">
                <h4>{{ Auth::user()->name }}</h4>
                <p>{{ Auth::user()->user_type }}</p>
            </div>
        </div>
        {{-- <button class="upgrade-btn">⭐ Upgrade now</button> --}}
    </div>

    <!-- Menu -->
    <ul class="menu-list">
        <li><a href="{{ route('dashboard') }}"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
        <li><a href="{{ url('/account') }}"><i class="bi bi-person-fill"></i> Account</a></li>
        <li>
            <a href="{{ route('models.show', ['slug' => Auth::user()->slug, 'tab' => 'photos']) }}">
                <i class="bi bi-image-fill"></i> My photos
            </a>
        </li>
        <li>
            <a href="{{ route('models.show', ['slug' => Auth::user()->slug, 'tab' => 'videos']) }}">
                <i class="bi bi-camera-reels-fill"></i> My videos
            </a>
        </li>
        <li><a href="#"><i class="bi bi-chat-dots-fill"></i> Messages</a></li>
        <li><a href="#"><i class="bi bi-calendar-event-fill"></i> Bookings</a></li>
        <li><a href="#"><i class="bi bi-people-fill"></i> Followers</a></li>
        <li><a href="#"><i class="bi bi-star-fill"></i> Reviews</a></li>
    </ul>
</aside>