@props([
    'title',
    'current' => null,
])

<nav aria-label="breadcrumb" class="account-breadcrumb mb-4">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ url('/account') }}">Account</a>
        </li>
        @if ($current)
            <li class="breadcrumb-item active" aria-current="page">{{ $current }}</li>
        @endif
    </ol>
    @if ($title)
        <h1 class="account-page__title mb-0 mt-2">{{ $title }}</h1>
    @endif
</nav>
