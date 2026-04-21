<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Pokemon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Cart
{
    private const KEY = 'cart';

    public const TYPE_POKEMON = 'pokemon';
    public const TYPE_ITEM = 'item';

    private const BUYABLE_CLASS = [
        self::TYPE_POKEMON => Pokemon::class,
        self::TYPE_ITEM    => Item::class,
    ];

    public static function items(): array
    {
        return Session::get(self::KEY, []);
    }

    public static function add(Model $buyable, int $quantity = 1): void
    {
        $type = self::typeFor($buyable);
        $key = self::key($type, $buyable->id);
        $cart = self::items();

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'key'        => $key,
                'type'       => $type,
                'id'         => $buyable->id,
                'name'       => $buyable->name,
                'price'      => (float) $buyable->price,
                'quantity'   => $quantity,
                'image_path' => $buyable->image_path,
            ];
        }

        Session::put(self::KEY, $cart);
    }

    public static function update(string $key, int $quantity): void
    {
        $cart = self::items();
        if (! isset($cart[$key])) {
            return;
        }
        if ($quantity <= 0) {
            unset($cart[$key]);
        } else {
            $cart[$key]['quantity'] = $quantity;
        }
        Session::put(self::KEY, $cart);
    }

    public static function remove(string $key): void
    {
        $cart = self::items();
        unset($cart[$key]);
        Session::put(self::KEY, $cart);
    }

    public static function clear(): void
    {
        Session::forget(self::KEY);
    }

    public static function total(): float
    {
        return array_sum(array_map(
            fn ($line) => $line['price'] * $line['quantity'],
            self::items()
        ));
    }

    public static function count(): int
    {
        return array_sum(array_column(self::items(), 'quantity'));
    }

    public static function key(string $type, int $id): string
    {
        return "{$type}:{$id}";
    }

    public static function classFor(string $type): ?string
    {
        return self::BUYABLE_CLASS[$type] ?? null;
    }

    public static function typeFor(Model $buyable): string
    {
        return match (true) {
            $buyable instanceof Pokemon => self::TYPE_POKEMON,
            $buyable instanceof Item    => self::TYPE_ITEM,
            default                     => throw new \InvalidArgumentException('Unsupported buyable: ' . $buyable::class),
        };
    }

    public static function resolve(string $type, int $id): ?Model
    {
        $class = self::classFor($type);
        return $class ? $class::find($id) : null;
    }
}
