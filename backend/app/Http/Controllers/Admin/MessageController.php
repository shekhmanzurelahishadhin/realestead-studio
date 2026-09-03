<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = ContactMessage::query()
            ->when($request->string('q')->trim()->value(), fn ($query, $term) => $query->where(
                fn ($q) => $q->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('subject', 'like', "%{$term}%")
            ))
            ->when($request->input('filter') === 'unread', fn ($query) => $query->where('is_read', false))
            ->when($request->input('filter') === 'read', fn ($query) => $query->where('is_read', true))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        // Opening a message is what marks it read; there is no separate action.
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    /** Flip the read flag straight from the list. */
    public function toggle(ContactMessage $message)
    {
        $message->update(['is_read' => ! $message->is_read]);

        return back()->with('status', $message->is_read ? 'Marked as read.' : 'Marked as unread.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('status', 'Message deleted.');
    }
}
