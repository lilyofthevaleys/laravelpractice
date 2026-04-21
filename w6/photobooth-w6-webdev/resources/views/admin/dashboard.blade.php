@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Overview of sales, customers, and subscriptions')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card card p-3">
                <div class="d-flex align-items-center gap-3">
                    <span class="stat-icon" style="background:#ee1515;"><i class="bi bi-cash-coin"></i></span>
                    <div>
                        <div class="text-muted small">Revenue (paid)</div>
                        <div class="fs-4 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card card p-3">
                <div class="d-flex align-items-center gap-3">
                    <span class="stat-icon" style="background:#1a1a1a;"><i class="bi bi-receipt"></i></span>
                    <div>
                        <div class="text-muted small">Transactions</div>
                        <div class="fs-4 fw-bold">{{ number_format($totalTransactions) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card card p-3">
                <div class="d-flex align-items-center gap-3">
                    <span class="stat-icon" style="background:#4f46e5;"><i class="bi bi-people-fill"></i></span>
                    <div>
                        <div class="text-muted small">Customers</div>
                        <div class="fs-4 fw-bold">{{ number_format($totalCustomers) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card card p-3">
                <div class="d-flex align-items-center gap-3">
                    <span class="stat-icon" style="background:#16a34a;"><i class="bi bi-stars"></i></span>
                    <div>
                        <div class="text-muted small">Active subs</div>
                        <div class="fs-4 fw-bold">{{ number_format($activeSubscriptions) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Inventory stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('admin.shop.index') }}" class="text-decoration-none text-dark">
                <div class="stat-card card p-3 h-100">
                    <div class="d-flex align-items-center gap-3">
                        <span class="stat-icon" style="background:#ee1515;"><i class="bi bi-heart-fill"></i></span>
                        <div>
                            <div class="text-muted small">Pokémon in shop</div>
                            <div class="fs-4 fw-bold">{{ number_format($totalPokemon) }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('admin.items.index') }}" class="text-decoration-none text-dark">
                <div class="stat-card card p-3 h-100">
                    <div class="d-flex align-items-center gap-3">
                        <span class="stat-icon" style="background:#1a1a1a;"><i class="bi bi-bag-fill"></i></span>
                        <div>
                            <div class="text-muted small">Items in shop</div>
                            <div class="fs-4 fw-bold">{{ number_format($totalItems) }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('admin.inbox.index', ['filter' => 'unread']) }}" class="text-decoration-none text-dark">
                <div class="stat-card card p-3 h-100">
                    <div class="d-flex align-items-center gap-3">
                        <span class="stat-icon" style="background:#f59e0b;"><i class="bi bi-envelope-fill"></i></span>
                        <div>
                            <div class="text-muted small">Unread messages</div>
                            <div class="fs-4 fw-bold">{{ number_format($unreadMessages) }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-12 col-xl-3">
            <div class="admin-card p-3 h-100">
                <div class="small text-muted mb-2 fw-bold">Items by category</div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach (\App\Models\Item::CATEGORY_LABELS as $key => $label)
                        @php $count = $itemsByCategory[$key] ?? 0; @endphp
                        <a href="{{ route('admin.items.index', ['category' => $key]) }}" class="text-decoration-none">
                            <span class="badge bg-light text-dark border fw-bold px-3 py-2">
                                {{ $label }}: <span style="color:#ee1515;">{{ $count }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="admin-card p-3 p-md-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 fw-bold">Sales — last 14 days</h5>
                    <span class="small text-muted">Paid transactions</span>
                </div>
                <canvas id="salesChart" height="110"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card p-3 p-md-4 h-100">
                <h5 class="fw-bold mb-3">Transactions by status</h5>
                <canvas id="statusChart" height="180"></canvas>
            </div>
        </div>
    </div>

    <div class="admin-card p-3 p-md-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-bold">Recent messages</h5>
            <a href="{{ route('admin.inbox.index') }}" class="small fw-bold text-decoration-none">Open inbox →</a>
        </div>
        @if ($recentMessages->isEmpty())
            <div class="text-center text-muted py-4">No messages yet.</div>
        @else
            <div class="list-group list-group-flush">
                @foreach ($recentMessages as $m)
                    <a href="{{ route('admin.inbox.show', $m) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start {{ $m->isUnread() ? 'fw-bold' : '' }}">
                        <div class="me-3" style="min-width: 0;">
                            <div class="d-flex align-items-center gap-2">
                                @if ($m->isUnread())
                                    <span class="badge rounded-pill" style="background:#ee1515;">&nbsp;</span>
                                @endif
                                <span>{{ $m->name }}</span>
                                <span class="badge bg-light text-dark border fw-normal">{{ $m->topic }}</span>
                            </div>
                            <div class="small text-muted text-truncate fw-normal">{{ \Illuminate\Support\Str::limit($m->message, 120) }}</div>
                        </div>
                        <div class="small text-muted fw-normal flex-shrink-0">{{ $m->created_at->diffForHumans() }}</div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="admin-card p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-bold">Recent transactions</h5>
            <a href="{{ route('admin.transactions.index') }}" class="small fw-bold text-decoration-none">View all →</a>
        </div>
        @if ($recentTransactions->isEmpty())
            <div class="text-center text-muted py-5">No transactions yet.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentTransactions as $t)
                            <tr>
                                <td class="fw-bold">{{ $t->order_code }}</td>
                                <td>{{ $t->user->name ?? '—' }}</td>
                                <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                <td><span class="badge-status badge-{{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                                <td class="text-muted small">{{ $t->created_at->format('d M Y, H:i') }}</td>
                                <td><a href="{{ route('admin.transactions.show', $t) }}" class="btn btn-sm btn-outline-dark">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    const salesData = @json($salesByDay);
    const statusData = @json($transactionsByStatus);

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: salesData.labels,
            datasets: [{
                label: 'Revenue',
                data: salesData.values,
                borderColor: '#ee1515',
                backgroundColor: 'rgba(238,21,21,0.12)',
                tension: 0.3,
                fill: true,
                pointRadius: 3,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } }
            }
        }
    });

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: ['#16a34a', '#f59e0b', '#ee1515', '#6b7280'],
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });
</script>
@endsection
