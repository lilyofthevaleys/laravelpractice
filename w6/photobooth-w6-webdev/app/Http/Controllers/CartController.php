<?php

namespace App\Http\Controllers;

use App\Services\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::items();
        $total = Cart::total();

        return view('cart', compact('items', 'total'));
    }

    public function add(Request $request, string $type, int $id)
    {
        $buyable = $this->resolveOrFail($type, $id);
        $quantity = max(1, (int) $request->input('quantity', 1));
        Cart::add($buyable, $quantity);

        return back()->with('success', "{$buyable->name} added to your bag.");
    }

    public function update(Request $request, string $type, int $id)
    {
        $key = Cart::key($type, $id);
        $quantity = (int) $request->input('quantity', 1);
        Cart::update($key, $quantity);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(string $type, int $id)
    {
        $buyable = Cart::resolve($type, $id);
        Cart::remove(Cart::key($type, $id));

        return back()->with('success', ($buyable ? "{$buyable->name} removed" : 'Item removed') . ' from cart.');
    }

    public function clear()
    {
        Cart::clear();

        return back()->with('success', 'Cart cleared.');
    }

    private function resolveOrFail(string $type, int $id)
    {
        $buyable = Cart::resolve($type, $id);
        if (! $buyable) {
            throw new NotFoundHttpException("Unknown buyable {$type}/{$id}");
        }
        return $buyable;
    }
}
