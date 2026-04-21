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

        $transaction = DB::transaction(function () use ($request, $planData) {
            $subscription = Subscription::create([
                'user_id'   => $request->user()->id,
                'plan_name' => $planData['name'],
                'price'     => $planData['price'],
                'status'    => Subscription::STATUS_ACTIVE,
                'starts_at' => now(),
                'ends_at'   => now()->addDays($planData['duration_days']),
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
