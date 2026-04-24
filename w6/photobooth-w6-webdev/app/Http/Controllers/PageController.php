<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokemon;
use App\Models\Item;
use App\Models\Subscription;
use App\Models\ContactMessage;

class PageController extends Controller
{
    public function shop(Request $request)
    {
        $validCategories = ['best-sellers', 'all', 'pokemon', 'pokeball', 'berry', 'medicine', 'general'];
        $category = $request->query('category', 'best-sellers');
        if (!in_array($category, $validCategories, true)) {
            $category = 'best-sellers';
        }

        $pokemonQuery = Pokemon::query();
        $itemQuery = Item::query();
        $showPokemon = true;
        $showItems = true;

        switch ($category) {
            case 'best-sellers':
                $pokemonQuery->where('is_best_seller', true);
                $itemQuery->where('is_best_seller', true);
                break;
            case 'pokemon':
                $showItems = false;
                break;
            case 'pokeball':
            case 'berry':
            case 'medicine':
            case 'general':
                $showPokemon = false;
                $itemQuery->where('category', $category);
                break;
            case 'all':
                break;
        }

        $pokemons = $showPokemon ? $pokemonQuery->orderBy('name')->get() : collect();
        $items    = $showItems    ? $itemQuery->orderBy('name')->get()    : collect();

        $filters = [
            'best-sellers' => 'Best Sellers',
            'all'          => 'All',
            'pokemon'      => 'Pokémon',
            'pokeball'     => 'Poké Balls',
            'berry'        => 'Berries',
            'medicine'     => 'Medicines',
            'general'      => 'General Items',
        ];

        $favouritedPokemonIds = collect();
        $favouritedItemIds = collect();
        if ($user = $request->user()) {
            $favouritedPokemonIds = $user->favourites()
                ->where('favouritable_type', Pokemon::class)
                ->pluck('favouritable_id');
            $favouritedItemIds = $user->favourites()
                ->where('favouritable_type', Item::class)
                ->pluck('favouritable_id');
        }

        return view('shop', compact('pokemons', 'items', 'category', 'filters', 'favouritedPokemonIds', 'favouritedItemIds'));
    }

    public function home()
    {
        $whyChooseUs = [
            [
                'title' => 'Certified Healthy',
                'description' => 'Every Pokémon is checked by a licensed Nurse Joy before pickup. Full health record included.',
            ],
            [
                'title' => 'From Every Region',
                'description' => 'Kanto, Johto, Hoenn, Sinnoh, and beyond — we source from trusted breeders and ranches worldwide.',
            ],
            [
                'title' => 'Trainer Support',
                'description' => 'First-time trainer? Our staff walk you through type matchups, evolution paths, and daily care.',
            ],
        ];

        $featured = Pokemon::inRandomOrder()->take(3)->get();

        $typeColors = [
            'Fire'=>'#ee8130','Water'=>'#6390f0','Grass'=>'#7ac74c','Electric'=>'#f7d02c',
            'Fairy'=>'#d685ad','Normal'=>'#a8a77a','Ghost'=>'#735797','Psychic'=>'#f95587',
            'Dragon'=>'#6f35fc','Rock'=>'#b6a136','Ground'=>'#e2bf65','Ice'=>'#96d9d6',
            'Bug'=>'#a6b91a','Flying'=>'#a98ff3','Fighting'=>'#c22e28','Poison'=>'#a33ea1',
            'Steel'=>'#b7b7ce','Dark'=>'#705746',
        ];
        $categoryColors = [
            'pokeball'=>'#ee1515','berry'=>'#a33ea1','medicine'=>'#6390f0','general'=>'#705746',
        ];

        $bestPokemon = Pokemon::where('is_best_seller', true)->inRandomOrder()->take(4)->get()
            ->map(fn ($p) => [
                'name'    => $p->name,
                'tagline' => $p->type . ' Type · HP ' . $p->hp,
                'badge'   => $p->type,
                'price'   => $p->price,
                'image'   => $p->image_path,
                'color'   => $typeColors[$p->type] ?? '#ee1515',
                'kind'    => 'pokemon',
            ]);

        $bestItems = Item::where('is_best_seller', true)->inRandomOrder()->take(4)->get()
            ->map(fn ($i) => [
                'name'    => $i->name,
                'tagline' => $i->categoryLabel(),
                'badge'   => $i->categoryLabel(),
                'price'   => $i->price,
                'image'   => $i->image_path,
                'color'   => $categoryColors[$i->category] ?? '#1a1a1a',
                'kind'    => 'item',
            ]);

        $bestSellers = $bestPokemon->concat($bestItems)->shuffle()->take(6)->values();

        return view('home', compact('whyChooseUs', 'featured', 'bestSellers'));
    }

    public function about()
    {
        return view('about');
    }

    public function services(Request $request)
    {
        $packages = collect(Subscription::PLANS)
            ->map(fn ($plan, $key) => array_merge($plan, [
                'key'   => $key,
                'price_label' => 'Rp ' . number_format($plan['price'], 0, ',', '.'),
            ]))
            ->values()
            ->all();

        $user = $request->user();
        $activeSub = $user && ! $user->isAdmin() ? $user->activeSubscription() : null;
        $pendingSub = $user && ! $user->isAdmin() && ! $activeSub ? $user->pendingSubscription() : null;
        $activePlanKey = $activeSub?->planKey();
        $pendingPlanKey = $pendingSub?->planKey();

        return view('services', compact('packages', 'activeSub', 'activePlanKey', 'pendingSub', 'pendingPlanKey'));
    }

    public function contact()
    {
        $topics = [
            'Buying a specific Pokémon',
            'Rookie Trainer plan',
            'Gym Challenger plan',
            'Elite Four Prep plan',
            'Custom / legendary request',
            'Something else',
        ];

        return view('contact', compact('topics'));
    }

    public function submitContact(Request $request)
    {
        $topics = [
            'Buying a specific Pokémon',
            'Rookie Trainer plan',
            'Gym Challenger plan',
            'Elite Four Prep plan',
            'Custom / legendary request',
            'Something else',
        ];

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:255'],
            'package' => ['required', 'string', 'in:' . implode(',', $topics)],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'package.in' => 'Please pick one of the listed topics.',
        ]);

        ContactMessage::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'topic'   => $validated['package'],
            'message' => $validated['message'],
        ]);

        return redirect()
            ->route('contact')
            ->with('success', "Thanks, {$validated['name']}! Your message is on its way — we'll reply to {$validated['email']} within 1-2 business days.");
    }
}
