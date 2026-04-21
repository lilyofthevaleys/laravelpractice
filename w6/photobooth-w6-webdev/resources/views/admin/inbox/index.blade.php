@extends('layouts.admin')

@section('title', 'Inbox')
@section('heading', 'Inbox')
@section('subheading', 'Messages from the Pokémart contact form')

@section('content')
    <div class="admin-card p-3 p-md-4">
        <div class="d-flex flex-wrap gap-2 mb-3">
            @php
                $tabs = [
                    'all'    => 'All',
                    'unread' => 'Unread',
                    'read'   => 'Read',
                ];
            @endphp
            @foreach ($tabs as $key => $label)
                <a href="{{ route('admin.inbox.index', ['filter' => $key]) }}"
                   class="btn btn-sm {{ $filter === $key ? 'btn-dark' : 'btn-outline-dark' }}">
                    {{ $label }}
                    <span class="badge bg-light text-dark ms-1">{{ $counts[$key] }}</span>
                </a>
            @endforeach
        </div>

        @if ($messages->isEmpty())
            <div class="text-center text-muted py-5">No messages in this view.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th style="width:40px;"></th>
                            <th>From</th>
                            <th>Topic</th>
                            <th>Preview</th>
                            <th>Received</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $m)
                            <tr class="{{ $m->isUnread() ? 'fw-bold' : '' }}">
                                <td>
                                    @if ($m->isUnread())
                                        <span class="badge rounded-pill" style="background:#ee1515;">&nbsp;</span>
                                    @else
                                        <i class="bi bi-envelope-open text-muted"></i>
                                    @endif
                                </td>
                                <td>
                                    {{ $m->name }}
                                    <div class="small text-muted fw-normal">{{ $m->email }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $m->topic }}</span>
                                </td>
                                <td class="text-muted fw-normal">{{ \Illuminate\Support\Str::limit($m->message, 80) }}</td>
                                <td class="text-muted small fw-normal">{{ $m->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.inbox.show', $m) }}" class="btn btn-sm btn-outline-dark">Open</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $messages->links() }}</div>
        @endif
    </div>
@endsection
