<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;
use RuntimeException;

class Midtrans
{
    public static function configured(): bool
    {
        return (bool) config('services.midtrans.server_key')
            && (bool) config('services.midtrans.client_key');
    }

    public static function clientKey(): ?string
    {
        return config('services.midtrans.client_key');
    }

    public static function isProduction(): bool
    {
        return (bool) config('services.midtrans.is_production');
    }

    public static function snapJsUrl(): string
    {
        return self::isProduction()
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }

    public static function boot(): void
    {
        if (! self::configured()) {
            throw new RuntimeException('Midtrans is not configured. Set MIDTRANS_SERVER_KEY and MIDTRANS_CLIENT_KEY.');
        }

        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = self::isProduction();
        Config::$isSanitized  = (bool) config('services.midtrans.is_sanitized');
        Config::$is3ds        = (bool) config('services.midtrans.is_3ds');
    }

    /**
     * Create a Snap token for the given transaction and store it on the model.
     */
    public static function createSnapTokenFor(Transaction $transaction): string
    {
        self::boot();

        $transaction->loadMissing(['user', 'items']);

        $itemDetails = $transaction->items->map(fn ($item) => [
            'id'       => (string) ($item->buyable_id ?? $item->id),
            'price'    => (int) round((float) $item->unit_price),
            'quantity' => (int) $item->quantity,
            'name'     => mb_strimwidth($item->name, 0, 50, ''),
        ])->values()->all();

        $grossAmount = (int) round((float) $transaction->total);
        $itemsTotal = array_sum(array_map(fn ($i) => $i['price'] * $i['quantity'], $itemDetails));
        if ($itemsTotal !== $grossAmount && $grossAmount !== 0) {
            $itemDetails[] = [
                'id'       => 'ADJ',
                'price'    => $grossAmount - $itemsTotal,
                'quantity' => 1,
                'name'     => 'Adjustment',
            ];
        }

        $orderId = $transaction->midtrans_order_id
            ?: $transaction->order_code . '-' . now()->format('YmdHis');

        $payload = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $transaction->user?->name ?? 'Guest',
                'email'      => $transaction->user?->email ?? 'guest@example.com',
            ],
            'callbacks' => [
                'finish' => route('checkout.pending', $transaction),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($payload);
        } catch (\Throwable $e) {
            Log::error('Midtrans Snap token creation failed', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }

        $transaction->forceFill([
            'midtrans_order_id' => $orderId,
            'snap_token'        => $snapToken,
        ])->save();

        return $snapToken;
    }

    /**
     * Fetch authoritative transaction status from Midtrans by order ID.
     * Used by the notification webhook to verify the payload we received.
     */
    public static function fetchStatus(string $orderId): object
    {
        self::boot();

        return MidtransTransaction::status($orderId);
    }

    /**
     * Verify Midtrans webhook signature.
     * Formula: sha512(order_id + status_code + gross_amount + server_key)
     */
    public static function verifySignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
    {
        $serverKey = (string) config('services.midtrans.server_key');
        $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        return hash_equals($expected, $signatureKey);
    }
}
