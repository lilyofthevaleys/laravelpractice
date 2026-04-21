<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $query = ContactMessage::query()->latest();
        if ($filter === 'unread') {
            $query->unread();
        } elseif ($filter === 'read') {
            $query->whereNotNull('read_at');
        } else {
            $filter = 'all';
        }

        $messages = $query->paginate(20)->withQueryString();

        $counts = [
            'all'    => ContactMessage::count(),
            'unread' => ContactMessage::unread()->count(),
            'read'   => ContactMessage::whereNotNull('read_at')->count(),
        ];

        return view('admin.inbox.index', compact('messages', 'filter', 'counts'));
    }

    public function show(ContactMessage $message)
    {
        $message->markRead();

        return view('admin.inbox.show', compact('message'));
    }

    public function markUnread(ContactMessage $message)
    {
        $message->markUnread();

        return redirect()
            ->route('admin.inbox.index')
            ->with('success', 'Message marked as unread.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()
            ->route('admin.inbox.index')
            ->with('success', 'Message deleted.');
    }
}
