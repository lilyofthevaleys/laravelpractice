@extends('layouts.admin')

@section('title', 'Users')
@section('heading', 'Users')
@section('subheading', 'All registered trainers and admins')

@section('content')
    <div class="admin-card p-3 p-md-4">
        @if ($users->isEmpty())
            <div class="text-center text-muted py-5">No users yet.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="small text-muted text-uppercase">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Transactions</th>
                            <th>Subscriptions</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            <tr>
                                <td class="fw-bold">{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td><span class="badge-status badge-role-{{ $u->role }}">{{ ucfirst($u->role) }}</span></td>
                                <td>{{ $u->transactions_count }}</td>
                                <td>{{ $u->subscriptions_count }}</td>
                                <td class="text-muted small">{{ $u->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $users->links() }}</div>
        @endif
    </div>
@endsection
