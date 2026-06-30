@props(['photo'])

<a href="{{ route('models.show', ['slug' => $photo->user->slug, 'tab' => 'photos']) }}" class="text-decoration-none model-card-link">
    <div class="card border-0 h-100 position-relative overflow-hidden model-card">
        <div class="ratio ratio-1x1">
            <img src="{{ asset('storage/' . $photo->file_path) }}"
                 class="card-img-top object-fit-cover model-card__image"
                 alt="{{ $photo->user->publicInfo->display_name ?? $photo->user->name }}"
                 loading="lazy">
        </div>

        <div class="card-img-overlay d-flex flex-column justify-content-end p-3 model-card__overlay">
            <span class="text-white fw-bold m-0 model-card__name">
                {{ $photo->user->publicInfo->display_name ?? $photo->user->name }}
            </span>
            <small class="text-white-50">
                <i class="bi bi-geo-alt-fill me-1"></i>{{ $photo->user->publicInfo->location ?? 'Kenya' }}
            </small>
        </div>
    </div>
</a>
