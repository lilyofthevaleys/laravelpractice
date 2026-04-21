<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pokemon;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function index()
    {
        $pokemons = Pokemon::orderBy('name')->paginate(20);

        return view('admin.shop.index', compact('pokemons'));
    }

    public function create()
    {
        return view('admin.shop.form', ['pokemon' => new Pokemon()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatePokemon($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->uploadImage($request->file('image'));
        }

        $data['is_best_seller'] = $request->boolean('is_best_seller');

        Pokemon::create($data);

        return redirect()->route('admin.shop.index')
            ->with('success', "Gotcha! {$data['name']} was added to the shop.");
    }

    public function edit(Pokemon $pokemon)
    {
        return view('admin.shop.form', compact('pokemon'));
    }

    public function update(Request $request, Pokemon $pokemon)
    {
        $data = $this->validatePokemon($request);

        if ($request->hasFile('image')) {
            if ($pokemon->image_path && !str_starts_with($pokemon->image_path, 'http') && file_exists(public_path($pokemon->image_path))) {
                @unlink(public_path($pokemon->image_path));
            }
            $data['image_path'] = $this->uploadImage($request->file('image'));
        }

        $data['is_best_seller'] = $request->boolean('is_best_seller');

        $pokemon->update($data);

        return redirect()->route('admin.shop.index')
            ->with('success', "{$pokemon->name} has been updated.");
    }

    public function toggleBestSeller(Pokemon $pokemon)
    {
        $pokemon->update(['is_best_seller' => ! $pokemon->is_best_seller]);

        return back()->with('success', $pokemon->is_best_seller
            ? "{$pokemon->name} is now a Best Seller."
            : "{$pokemon->name} removed from Best Sellers.");
    }

    public function destroy(Pokemon $pokemon)
    {
        if ($pokemon->image_path && file_exists(public_path($pokemon->image_path))) {
            @unlink(public_path($pokemon->image_path));
        }

        $name = $pokemon->name;
        $pokemon->delete();

        return redirect()->route('admin.shop.index')
            ->with('success', "{$name} was released back to the wild.");
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
}
