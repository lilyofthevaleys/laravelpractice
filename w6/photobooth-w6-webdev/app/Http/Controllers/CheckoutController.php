<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\Cart;
use App\Services\Midtrans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show()
    {
        $items = Cart::items();
        $total = Cart::total();

        if (empty($items)) {
            return redirect()->route('cart.index')->with('success', 'Your cart is empty.');
        }

        return view('checkout', compact('items', 'total'));
    }

    public function process(Request $request)
    {
        $items = Cart::items();
        if (empty($items)) {
            return redirect()->route('cart.index');
        }

        $transaction = DB::transaction(function () use ($request, $items) {
            $t = Transaction::create([
                'user_id' => $request->user()->id,
                'order_code' => 'PM-' . strtoupper(Str::random(8)),
                'total' => Cart::total(),
                'status' => Transaction::STATUS_PENDING,
                'payment_method' => 'midtrans',
            ]);

            foreach ($items as $line) {
                $class = Cart::classFor($line['type'] ?? Cart::TYPE_POKEMON);
                $t->items()->create([
                    'buyable_type' => $class,
                    'buyable_id'   => $line['id'],
                    'name'         => $line['name'],
                    'unit_price'   => $line['price'],
                    'quantity'     => $line['quantity'],
                    'subtotal'     => $line['price'] * $line['quantity'],
                ]);
            }

            return $t;
        });

        Cart::clear();

        if (Midtrans::configured()) {
            try {
                Midtrans::createSnapTokenFor($transaction);
            } catch (\Throwable $e) {
                Log::error('Failed to create Snap token at checkout', [
                    'transaction_id' => $transaction->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return redirect()->route('checkout.pending', $transaction)
            ->with('success', "Order {$transaction->order_code} placed. Awaiting payment.");
    }

    public function pending(Transaction $transaction)
    {
        abort_unless($transaction->user_id === auth()->id(), 403);

        if (
            Midtrans::configured()
            && $transaction->status === Transaction::STATUS_PENDING
            && ! $transaction->snap_token
        ) {
            try {
                Midtrans::createSnapTokenFor($transaction);
            } catch (\Throwable $e) {
                Log::error('Failed to refresh Snap token on pending page', [
                    'transaction_id' => $transaction->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return view('checkout-pending', compact('transaction'));
    }
}
