<div class="account-review-card mb-3">
    <div class="d-flex gap-3">
        @if($type === 'received')
            <img src="{{ $review->reviewer->avatarUrl(64) }}" alt="" class="rounded-circle" width="44" height="44">
            <div class="flex-grow-1">
                <div class="d-flex flex-wrap justify-content-between gap-2 mb-1">
                    <strong>{{ $review->reviewer->displayName() }}</strong>
                    <span class="text-muted small">{{ $review->created_at->format('M d, Y') }}</span>
                </div>
        @else
            <img src="{{ $review->model->avatarUrl(64) }}" alt="" class="rounded-circle" width="44" height="44">
            <div class="flex-grow-1">
                <div class="d-flex flex-wrap justify-content-between gap-2 mb-1">
                    <strong>{{ $review->model->displayName() }}</strong>
                    <span class="text-muted small">{{ $review->created_at->format('M d, Y') }}</span>
                </div>
        @endif
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
