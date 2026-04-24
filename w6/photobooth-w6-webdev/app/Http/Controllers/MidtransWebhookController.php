<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Transaction;
use App\Services\Midtrans;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function notification(Request $request): JsonResponse
    {
        if (! Midtrans::configured()) {
            return response()->json(['error' => 'Midtrans not configured'], 503);
        }

        $payload = $request->all();
        $orderId       = $payload['order_id']       ?? null;
        $statusCode    = $payload['status_code']    ?? null;
        $grossAmount   = $payload['gross_amount']   ?? null;
        $signatureKey  = $payload['signature_key']  ?? null;

        if (! $orderId || ! $statusCode || ! $grossAmount || ! $signatureKey) {
            Log::warning('Midtrans notification missing fields', ['payload_keys' => array_keys($payload)]);
            return response()->json(['error' => 'Invalid notification'], 400);
        }

        if (! Midtrans::verifySignature($orderId, $statusCode, $grossAmount, $signatureKey)) {
            Log::warning('Midtrans notification signature mismatch', ['order_id' => $orderId]);
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        try {
            $authoritative = Midtrans::fetchStatus($orderId);
        } catch (\Throwable $e) {
            Log::error('Midtrans status fetch failed', ['order_id' => $orderId, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Status fetch failed'], 502);
        }

        $txStatus    = $authoritative->transaction_status ?? null;
        $fraudStatus = $authoritative->fraud_status       ?? null;
        $paymentType = $authoritative->payment_type       ?? null;

        $transaction = Transaction::where('midtrans_order_id', $orderId)->first();
        if (! $transaction) {
            Log::warning('Midtrans notification for unknown order', ['order_id' => $orderId]);
            return response()->json(['error' => 'Order not found'], 404);
        }

        $newStatus = $this->mapStatus($txStatus, $fraudStatus);
        if ($newStatus === null) {
            Log::info('Midtrans notification ignored', [
                'order_id' => $orderId,
                'transaction_status' => $txStatus,
                'fraud_status' => $fraudStatus,
            ]);
            return response()->json(['message' => 'Ignored']);
        }

        $updates = ['status' => $newStatus];
        if ($paymentType) {
            $updates['payment_method'] = $paymentType;
        }
        if ($newStatus === Transaction::STATUS_PAID && ! $transaction->paid_at) {
            $updates['paid_at'] = now();
        }

        $transaction->forceFill($updates)->save();

        $this->syncSubscription($transaction, $newStatus);

        Log::info('Midtrans notification processed', [
            'order_id' => $orderId,
            'status'   => $newStatus,
        ]);

        return response()->json(['message' => 'OK']);
    }

    private function syncSubscription(Transaction $transaction, string $newStatus): void
    {
        $subscriptionItem = $transaction->items()
            ->where('buyable_type', Subscription::class)
            ->first();

        if (! $subscriptionItem) {
            return;
        }

        $subscription = Subscription::find($subscriptionItem->buyable_id);
        if (! $subscription) {
            return;
        }

        if ($newStatus === Transaction::STATUS_PAID) {
            $plan = Subscription::findPlan($subscription->planKey() ?? '');
            $days = $plan['duration_days'] ?? 30;
            $subscription->update([
                'status'    => Subscription::STATUS_ACTIVE,
                'starts_at' => now(),
                'ends_at'   => now()->addDays($days),
            ]);
        } elseif (in_array($newStatus, [Transaction::STATUS_FAILED, Transaction::STATUS_CANCELLED], true)) {
            if ($subscription->status === Subscription::STATUS_PENDING) {
                $subscription->update(['status' => Subscription::STATUS_CANCELLED]);
            }
        }
    }

    private function mapStatus(?string $txStatus, ?string $fraudStatus): ?string
    {
        return match ($txStatus) {
            'capture' => $fraudStatus === 'accept' ? Transaction::STATUS_PAID : Transaction::STATUS_PENDING,
            'settlement' => Transaction::STATUS_PAID,
            'pending' => Transaction::STATUS_PENDING,
            'deny', 'expire' => Transaction::STATUS_FAILED,
            'cancel' => Transaction::STATUS_CANCELLED,
            default => null,
        };
    }
}
