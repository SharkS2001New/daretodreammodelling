<aside id="layout-menu" class="menu-sidebar">
    <!-- Profile Section -->
    <div class="profile">
        <div class="profile-container">
            <div class="profile-pic">
                <img src="{{ $publicInfo && $publicInfo->profile_picture 
                                ? asset('storage/'.$publicInfo->profile_picture) 
                                : asset('images/default-profile.png') }}" 
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
        <li><a href="/dashboard"><i class="bx bx-home"></i> Dashboard</a></li>
        <li><a href="/account"><i class="bx bx-user"></i> Account</a></li>
        <li>
            <a href="{{ route('models.show', ['slug' => Auth::user()->slug, 'tab' => 'photos']) }}">
                <i class="bx bx-image"></i> My photos
            </a>
        </li>
        <li><a href="/model/{{Auth::user()->slug}}/?tab=videos"><i class="bx bx-video"></i> Videos</a></li>
        <li><a href="#"><i class="bx bx-message"></i> Messages</a></li> 
        <li><a href="#"><i class="bx bx-calendar"></i> Bookings</a></li>
        <li><a href="#"><i class="bx bx-user-check"></i> Followers</a></li>
        <li><a href="#"><i class="bx bx-star"></i> Reviews</a></li>
    </ul>
</aside>