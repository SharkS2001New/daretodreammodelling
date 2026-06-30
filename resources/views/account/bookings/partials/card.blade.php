<div class="account-booking-card mb-3">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
        <div>
            <h3 class="h6 fw-bold mb-1">{{ $booking->title }}</h3>
            <p class="text-muted small mb-0">
                @if($role === 'model')
                    From <strong>{{ $booking->client->displayName() }}</strong>
                @else
                    With <strong>{{ $booking->model->displayName() }}</strong>
                @endif
                · {{ $booking->event_date->format('M d, Y g:i A') }}
            </p>
        </div>
        <span class="badge account-badge {{ $booking->statusBadgeClass() }}">{{ $booking->statusLabel() }}</span>
    </div>

    @if($booking->location)
        <p class="small mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $booking->location }}</p>
    @endif

    @if($booking->description)
        <p class="small mb-2">{{ $booking->description }}</p>
    @endif

    @if($booking->notes)
        <p class="small text-muted mb-2"><em>Notes: {{ $booking->notes }}</em></p>
    @endif

    <form action="{{ route('account.bookings.update', $booking) }}" method="POST" class="account-booking-card__actions">
        @csrf
        @method('PATCH')

        @if($role === 'model' && in_array($booking->status, ['pending', 'confirmed']))
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <select name="status" class="form-select form-select-sm" style="max-width: 160px;">
                    <option value="pending" @selected($booking->status === 'pending')>Pending</option>
                    <option value="confirmed" @selected($booking->status === 'confirmed')>Confirmed</option>
                    <option value="completed" @selected($booking->status === 'completed')>Completed</option>
                    <option value="cancelled" @selected($booking->status === 'cancelled')>Cancelled</option>
                </select>
                <input type="text" name="notes" value="{{ $booking->notes }}" placeholder="Add a note..."
                    class="form-control form-control-sm" style="max-width: 220px;">
                <button type="submit" class="btn btn-sm btn-primary">Update</button>
            </div>
        @elseif($role === 'client' && in_array($booking->status, ['pending', 'confirmed']))
            <input type="hidden" name="status" value="cancelled">
            <button type="submit" class="btn btn-sm btn-outline-danger"
                onclick="return confirm('Cancel this booking request?')">Cancel request</button>
        @endif
    </form>
</div>
