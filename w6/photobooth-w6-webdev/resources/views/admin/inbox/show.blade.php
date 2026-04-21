@extends('layouts.admin')

@section('title', 'Message from ' . $message->name)
@section('heading', $message->topic)
@section('subheading', 'Received ' . $message->created_at->format('d M Y, H:i'))

@section('content')
    <div class="mb-3"><a href="{{ route('admin.inbox.index') }}" class="text-decoration-none">← Back to inbox</a></div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="admin-card p-3 p-md-4">
                <h5 class="fw-bold mb-3">Message</h5>
                <p class="mb-0" style="white-space: pre-wrap;">{{ $message->message }}</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card p-3 p-md-4 mb-3">
                <h5 class="fw-bold mb-3">Sender</h5>
                <dl class="mb-0">
                    <dt class="small text-muted">Name</dt>
                    <dd>{{ $message->name }}</dd>

                    <dt class="small text-muted">Email</dt>
                    <dd><a href="mailto:{{ $message->email }}?subject=Re: {{ $message->topic }}">{{ $message->email }}</a></dd>

                    <dt class="small text-muted">Topic</dt>
                    <dd>{{ $message->topic }}</dd>

                    <dt class="small text-muted">Status</dt>
                    <dd>
                        @if ($message->isUnread())
                            <span class="badge-status badge-pending">Unread</span>
                        @else
                            <span class="badge-status badge-active">Read {{ $message->read_at->diffForHumans() }}</span>
                        @endif
                    </dd>
                </dl>
            </div>

            <div class="admin-card p-3 p-md-4">
                <h5 class="fw-bold mb-3">Actions</h5>
                <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->topic }}" class="btn btn-poke w-100 mb-2">
                    <i class="bi bi-reply-fill"></i> Reply by email
                </a>
                <form method="POST" action="{{ route('admin.inbox.markUnread', $message) }}" class="m-0 mb-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-outline-dark w-100">Mark as unread</button>
                </form>
                <form method="POST" action="{{ route('admin.inbox.destroy', $message) }}" class="m-0"
                      onsubmit="return confirm('Delete this message? This cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">Delete message</button>
                </form>
            </div>
        </div>
    </div>
@endsection
