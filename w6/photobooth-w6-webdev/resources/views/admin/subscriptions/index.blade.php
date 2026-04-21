@extends('layouts.admin')

@section('title', 'Subscriptions')
@section('heading', 'Subscriptions')
@section('subheading', 'Trainer plan enrollments')

@section('content')
    <div class="admin-card p-3 p-md-4">
        @if ($subscriptions->isEmpty())
            <div class="text-center text-muted py-5">No subscriptions yet.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="small text-muted text-uppercase">
                        <tr>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Starts</th>
                            <th>Ends</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $s)
                            <tr>
                                <td>{{ $s->user->name ?? '—' }}<div class="small text-muted">{{ $s->user->email ?? '' }}</div></td>
                                <td class="fw-bold">{{ $s->plan_name }}</td>
                                <td>Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                                <td><span class="badge-status badge-{{ $s->status }}">{{ ucfirst($s->status) }}</span></td>
                                <td class="text-muted small">{{ optional($s->starts_at)->format('d M Y') ?? '—' }}</td>
                                <td class="text-muted small">{{ optional($s->ends_at)->format('d M Y') ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $subscriptions->links() }}</div>
        @endif
    </div>
@endsection
