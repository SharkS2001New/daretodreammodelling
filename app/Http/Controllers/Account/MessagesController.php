<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $messages = Message::where('sender_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->with(['sender.publicInfo', 'recipient.publicInfo'])
            ->latest()
            ->get();

        $conversations = $messages->groupBy(function ($message) use ($userId) {
            return $message->sender_id === $userId
                ? $message->recipient_id
                : $message->sender_id;
        })->map(function ($thread) {
            return $thread->first();
        })->sortByDesc('created_at');

        $unreadCount = Message::where('recipient_id', $userId)
            ->whereNull('read_at')
            ->count();

        return view('account.messages.index', compact('conversations', 'unreadCount'));
    }

    public function show(User $user)
    {
        $authUser = Auth::user();

        if ($user->id === $authUser->id) {
            return redirect()->route('account.messages.index');
        }

        $thread = Message::where(function ($query) use ($authUser, $user) {
            $query->where('sender_id', $authUser->id)
                ->where('recipient_id', $user->id);
        })->orWhere(function ($query) use ($authUser, $user) {
            $query->where('sender_id', $user->id)
                ->where('recipient_id', $authUser->id);
        })
            ->with(['sender.publicInfo', 'recipient.publicInfo'])
            ->orderBy('created_at')
            ->get();

        Message::where('sender_id', $user->id)
            ->where('recipient_id', $authUser->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('account.messages.show', compact('user', 'thread'));
    }

    public function store(Request $request, User $user)
    {
        $authUser = Auth::user();

        if ($user->id === $authUser->id) {
            return back()->with('error', 'You cannot message yourself.');
        }

        $validated = $request->validate([
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string|max:5000',
        ]);

        Message::create([
            'sender_id' => $authUser->id,
            'recipient_id' => $user->id,
            'subject' => $validated['subject'] ?? null,
            'body' => $validated['body'],
        ]);

        return redirect()
            ->route('account.messages.show', $user)
            ->with('success', 'Message sent.');
    }
}
