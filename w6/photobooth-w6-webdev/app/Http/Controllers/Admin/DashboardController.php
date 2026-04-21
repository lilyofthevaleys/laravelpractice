<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Pokemon;
use App\Models\Item;
use App\Models\ContactMessage;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $paidStatus = Transaction::STATUS_PAID;

        $totalRevenue = Transaction::where('status', $paidStatus)->sum('total');
        $totalTransactions = Transaction::count();
        $totalCustomers = User::where('role', User::ROLE_CUSTOMER)->count();
        $activeSubscriptions = Subscription::where('status', Subscription::STATUS_ACTIVE)->count();

        $salesByDay = $this->salesLastNDays(14);
        $transactionsByStatus = Transaction::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(8)
            ->get();

        $totalPokemon = Pokemon::count();
        $totalItems = Item::count();
        $itemsByCategory = Item::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        $unreadMessages = ContactMessage::unread()->count();
        $recentMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalTransactions',
            'totalCustomers',
            'activeSubscriptions',
            'salesByDay',
            'transactionsByStatus',
            'recentTransactions',
            'totalPokemon',
            'totalItems',
            'itemsByCategory',
            'unreadMessages',
            'recentMessages'
        ));
    }

    private function salesLastNDays(int $days): array
    {
        $start = Carbon::today()->subDays($days - 1);

        $rows = Transaction::where('status', Transaction::STATUS_PAID)
            ->where('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as day, SUM(total) as total')
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $labels = [];
        $values = [];
        for ($i = 0; $i < $days; $i++) {
            $date = $start->copy()->addDays($i)->toDateString();
            $labels[] = Carbon::parse($date)->format('M d');
            $values[] = (float) ($rows[$date] ?? 0);
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
