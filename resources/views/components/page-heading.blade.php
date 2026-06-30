@props([
    'title' => null,
    'subtitle' => null,
    'centered' => true,
])

@php
    $heading = $title ?? ($pageHeading ?? null);
    $sub = $subtitle ?? ($pageSubtitle ?? null);
@endphp

@if ($heading)
    <div {{ $attributes->merge(['class' => 'page-heading' . ($centered ? ' page-heading--center' : '')]) }}>
        <h1 class="page-heading__title">{{ $heading }}</h1>
        @if ($sub)
            <p class="page-heading__subtitle">{!! $sub !!}</p>
        @endif
    </div>
@endif
