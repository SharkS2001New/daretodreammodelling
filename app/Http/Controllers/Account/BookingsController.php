<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $asModel = Booking::where('model_id', $user->id)
            ->with(['client.publicInfo'])
            ->latest('event_date')
            ->paginate(15, ['*'], 'model_page');

        $asClient = Booking::where('client_id', $user->id)
            ->with(['model.publicInfo'])
            ->latest('event_date')
            ->paginate(15, ['*'], 'client_page');

        return view('account.bookings.index', compact('asModel', 'asClient'));
    }

    public function create(?User $model = null)
    {
        if ($model && $model->id === Auth::id()) {
            return redirect()->route('account.bookings.index')
                ->with('error', 'You cannot book yourself.');
        }

        return view('account.bookings.create', compact('model'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'model_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'event_date' => 'required|date|after:now',
            'location' => 'nullable|string|max:255',
        ]);

        if ((int) $validated['model_id'] === Auth::id()) {
            return back()->with('error', 'You cannot book yourself.')->withInput();
        }

        Booking::create([
            'model_id' => $validated['model_id'],
            'client_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'event_date' => $validated['event_date'],
            'location' => $validated['location'] ?? null,
            'status' => Booking::STATUS_PENDING,
        ]);

        return redirect()->route('account.bookings.index')
            ->with('success', 'Booking request submitted successfully.');
    }

    public function update(Request $request, Booking $booking)
    {
        $user = Auth::user();

        if ($booking->model_id !== $user->id && $booking->client_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', Booking::statuses()),
            'notes' => 'nullable|string|max:2000',
        ]);

        if ($booking->client_id === $user->id && $validated['status'] !== Booking::STATUS_CANCELLED) {
            return back()->with('error', 'You can only cancel your own booking requests.');
        }

        $booking->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $booking->notes,
        ]);

        return back()->with('success', 'Booking updated.');
    }
}
