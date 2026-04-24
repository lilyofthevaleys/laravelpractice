<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Transaction;
use App\Services\Midtrans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function confirm(Request $request, string $plan)
    {
        $planData = Subscription::findPlan($plan);
        abort_unless($planData, 404, 'Plan not found.');

        if ($request->user()->isAdmin()) {
            return redirect()->route('services')
                ->with('success', 'Admins manage subscriptions, they don\'t buy them.');
        }

        if ($active = $request->user()->activeSubscription()) {
            return redirect()->route('services')
                ->with('success', "You're already on {$active->plan_name} until {$active->ends_at->format('d M Y')}.");
        }

        if ($pending = $request->user()->pendingSubscription()) {
            $pendingTx = Transaction::whereHas('items', function ($q) use ($pending) {
                $q->where('buyable_type', Subscription::class)->where('buyable_id', $pending->id);
            })->where('status', Transaction::STATUS_PENDING)->latest()->first();
            if ($pendingTx) {
                return redirect()->route('checkout.pending', $pendingTx)
                    ->with('success', "You have a pending subscription to {$pending->plan_name}. Complete payment to activate.");
            }
        }

        return view('subscribe-confirm', [
            'planKey'  => $plan,
            'plan'     => $planData,
            'endsAt'   => now()->addDays($planData['duration_days']),
        ]);
    }

    public function subscribe(Request $request, string $plan)
    {
        $planData = Subscription::findPlan($plan);
        abort_unless($planData, 404, 'Plan not found.');

        if ($request->user()->isAdmin()) {
            return redirect()->route('services')
                ->with('success', 'Admins manage subscriptions, they don\'t buy them.');
        }

        if ($active = $request->user()->activeSubscription()) {
            return redirect()->route('services')
                ->with('success', "You already have an active {$active->plan_name} plan until {$active->ends_at->format('d M Y')}.");
        }

        if ($pending = $request->user()->pendingSubscription()) {
            $pendingTx = Transaction::whereHas('items', function ($q) use ($pending) {
                $q->where('buyable_type', Subscription::class)->where('buyable_id', $pending->id);
            })->where('status', Transaction::STATUS_PENDING)->latest()->first();
            if ($pendingTx) {
                return redirect()->route('checkout.pending', $pendingTx)
                    ->with('success', "Finish paying for your pending {$pending->plan_name} subscription first.");
            }
        }

        $transaction = DB::transaction(function () use ($request, $planData) {
            $subscription = Subscription::create([
                'user_id'   => $request->user()->id,
                'plan_name' => $planData['name'],
                'price'     => $planData['price'],
                'status'    => Subscription::STATUS_PENDING,
                'starts_at' => null,
                'ends_at'   => null,
            ]);

            $t = Transaction::create([
                'user_id'        => $request->user()->id,
                'order_code'     => 'PM-SUB-' . strtoupper(Str::random(6)),
                'total'          => $planData['price'],
                'status'         => Transaction::STATUS_PENDING,
                'payment_method' => 'midtrans',
            ]);

            $t->items()->create([
                'buyable_type' => Subscription::class,
                'buyable_id'   => $subscription->id,
                'name'         => $planData['name'] . ' (' . $planData['duration_days'] . '-day plan)',
                'unit_price'   => $planData['price'],
                'quantity'     => 1,
                'subtotal'     => $planData['price'],
            ]);

            return $t;
        });

        if (Midtrans::configured()) {
            try {
                Midtrans::createSnapTokenFor($transaction);
            } catch (\Throwable $e) {
                Log::error('Failed to create Snap token for subscription', [
                    'transaction_id' => $transaction->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return redirect()
            ->route('checkout.pending', $transaction)
            ->with('success', "Subscribed to {$planData['name']}. Complete payment to activate.");
    }
}
