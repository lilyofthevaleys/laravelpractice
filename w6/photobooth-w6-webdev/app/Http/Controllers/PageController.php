<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokemon;

class PageController extends Controller
{
    public function shop()
    {
        $pokemons = Pokemon::orderBy('name')->get();
        return view('shop', compact('pokemons'));
    }

    public function createPokemon()
    {
        return view('pokemon-form', ['pokemon' => new Pokemon()]);
    }

    public function storePokemon(Request $request)
    {
        $data = $this->validatePokemon($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->uploadImage($request->file('image'));
        }

        Pokemon::create($data);

        return redirect()->route('shop')->with('success', "Gotcha! {$data['name']} was added to the shop.");
    }

    public function editPokemon(Pokemon $pokemon)
    {
        return view('pokemon-form', compact('pokemon'));
    }

    public function updatePokemon(Request $request, Pokemon $pokemon)
    {
        $data = $this->validatePokemon($request);

        if ($request->hasFile('image')) {
            if ($pokemon->image_path && file_exists(public_path($pokemon->image_path))) {
                @unlink(public_path($pokemon->image_path));
            }
            $data['image_path'] = $this->uploadImage($request->file('image'));
        }

        $pokemon->update($data);

        return redirect()->route('shop')->with('success', "{$pokemon->name} has been updated.");
    }

    public function destroyPokemon(Pokemon $pokemon)
    {
        if ($pokemon->image_path && file_exists(public_path($pokemon->image_path))) {
            @unlink(public_path($pokemon->image_path));
        }

        $name = $pokemon->name;
        $pokemon->delete();

        return redirect()->route('shop')->with('success', "{$name} was released back to the wild.");
    }

    private function validatePokemon(Request $request): array
    {
        return $request->validate([
            'name'    => 'required|string|max:100',
            'type'    => 'required|string|max:50',
            'hp'      => 'required|integer|min:1|max:999',
            'price'   => 'required|numeric|min:0',
            'stock'   => 'required|integer|min:0',
            'details' => 'nullable|string|max:1000',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required'  => 'Every Pokemon needs a name.',
            'type.required'  => 'Pick a type (Fire, Water, Grass, ...).',
            'hp.required'    => 'HP is required.',
            'price.required' => 'Set a price in Rupiah.',
            'image.image'    => 'Upload an image file.',
            'image.max'      => 'Image must be 2MB or smaller.',
        ]);
    }

    private function uploadImage($file): string
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('pokemon_image'), $filename);
        return 'pokemon_image/' . $filename;
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

        return view('home', compact('whyChooseUs', 'featured'));
    }

    public function about()
    {
        return view('about');
    }

    public function services()
    {
        $packages = [
            [
                'name' => 'Rookie Trainer',
                'price' => 'Rp 1.500.000',
                'duration' => '/month',
                'is_popular' => false,
                'btn_text' => 'Start Journey',
                'features' => [
                    '1 Starter Pokémon of your choice',
                    '5 Poké Balls',
                    'Basic Trainer Card',
                    'Access to Beginner Route',
                ],
            ],
            [
                'name' => 'Gym Challenger',
                'price' => 'Rp 3.500.000',
                'duration' => '/month',
                'is_popular' => true,
                'btn_text' => 'Take The Challenge',
                'features' => [
                    'Everything in Rookie',
                    '10 Great Balls + 5 Potions',
                    'Gym Badge Holder',
                    'Type Matchup Cheat Sheet',
                    'Free Nurse Joy visits',
                ],
            ],
            [
                'name' => 'Elite Four Prep',
                'price' => 'Rp 7.000.000',
                'duration' => '/month',
                'is_popular' => false,
                'btn_text' => 'Aim For Champion',
                'features' => [
                    'Everything in Challenger',
                    '5 Ultra Balls + Full Restore Kit',
                    'Rare Candy (x3)',
                    'TM library access',
                    'Mock battles with Champion staff',
                ],
            ],
        ];

        return view('services', compact('packages'));
    }

    public function contact()
    {
        return view('contact');
    }
}
