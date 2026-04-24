<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $statuses = [
            Transaction::STATUS_PENDING,
            Transaction::STATUS_PAID,
            Transaction::STATUS_FAILED,
            Transaction::STATUS_CANCELLED,
        ];

        $status = $request->query('status');
        if (! in_array($status, $statuses, true)) {
            $status = null;
        }

        $query = $request->user()->transactions()->with('items');
        if ($status) {
            $query->where('status', $status);
        }

        $transactions = $query->latest()->paginate(15)->withQueryString();

        $counts = $request->user()->transactions()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('orders.index', compact('transactions', 'status', 'counts'));
    }

    public function cancel(Request $request, Transaction $transaction)
    {
        abort_unless($transaction->user_id === $request->user()->id, 403);

        if ($transaction->status !== Transaction::STATUS_PENDING) {
            return back()->with('success', 'Only pending orders can be cancelled.');
        }

        $transaction->update([
            'status'     => Transaction::STATUS_CANCELLED,
            'snap_token' => null,
        ]);

        $subscriptionItem = $transaction->items()
            ->where('buyable_type', Subscription::class)
            ->first();
        if ($subscriptionItem) {
            Subscription::where('id', $subscriptionItem->buyable_id)
                ->where('status', Subscription::STATUS_PENDING)
                ->update(['status' => Subscription::STATUS_CANCELLED]);
        }

        return redirect()->route('orders.index')
            ->with('success', "Order {$transaction->order_code} has been cancelled.");
    }
}
