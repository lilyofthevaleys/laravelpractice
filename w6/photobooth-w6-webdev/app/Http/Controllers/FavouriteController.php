<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Item;
use App\Models\Pokemon;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    private const TYPE_CLASS = [
        'pokemon' => Pokemon::class,
        'item'    => Item::class,
    ];

    public function index(Request $request)
    {
        $favourites = $request->user()->favourites()
            ->with('favouritable')
            ->latest()
            ->paginate(12);

        return view('favourites.index', compact('favourites'));
    }

    public function toggle(Request $request, string $type, int $id)
    {
        $class = self::TYPE_CLASS[$type];
        abort_unless($class::query()->whereKey($id)->exists(), 404);

        $user = $request->user();
        $existing = $user->favourites()
            ->where('favouritable_type', $class)
            ->where('favouritable_id', $id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Removed from favourites.';
        } else {
            Favourite::create([
                'user_id'           => $user->id,
                'favouritable_type' => $class,
                'favouritable_id'   => $id,
            ]);
            $message = 'Added to favourites.';
        }

        return back()->with('success', $message);
    }
}
