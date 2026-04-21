<?php

namespace Database\Seeders;

use App\Models\Pokemon;
use Illuminate\Database\Seeder;

class PokemonSeeder extends Seeder
{
    public function run(): void
    {
        $artwork = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/';

        $pokemons = [
            ['dex' => 1,   'name' => 'Bulbasaur',   'type' => 'Grass',    'hp' => 45,  'price' => 1500000, 'stock' => 5, 'best' => true,  'details' => 'A Grass/Poison-type starter. Carries a seed on its back that sprouts as it grows. Loyal, patient, and makes a calm first partner.'],
            ['dex' => 4,   'name' => 'Charmander',  'type' => 'Fire',     'hp' => 39,  'price' => 1800000, 'stock' => 4, 'best' => true,  'details' => 'A Fire-type starter. The flame on its tail mirrors its mood — keep it dry and keep it fed to see it evolve into a mighty Charizard.'],
            ['dex' => 7,   'name' => 'Squirtle',    'type' => 'Water',    'hp' => 44,  'price' => 1600000, 'stock' => 6, 'best' => true,  'details' => 'A Water-type starter. Blasts high-pressure jets from its mouth. Its shell hardens with age, making it a tank-in-training.'],
            ['dex' => 25,  'name' => 'Pikachu',     'type' => 'Electric', 'hp' => 35,  'price' => 2500000, 'stock' => 3, 'best' => true,  'details' => 'The iconic Electric-type mascot of the Kanto region. Stores electricity in its cheek pouches and releases it when excited — or annoyed.'],
            ['dex' => 39,  'name' => 'Jigglypuff',  'type' => 'Fairy',    'hp' => 115, 'price' => 900000,  'stock' => 8, 'best' => false, 'details' => 'Normal/Fairy-type. Sings a lullaby that puts anyone listening to sleep — including itself, usually. Comes with a permanent marker for drawing on sleeping trainers.'],
            ['dex' => 133, 'name' => 'Eevee',       'type' => 'Normal',   'hp' => 55,  'price' => 2200000, 'stock' => 2, 'best' => true,  'details' => 'Normal-type. Unstable genetic structure lets it evolve into eight different forms. Choose your stone wisely.'],
            ['dex' => 143, 'name' => 'Snorlax',     'type' => 'Normal',   'hp' => 160, 'price' => 3000000, 'stock' => 1, 'best' => false, 'details' => 'Normal-type heavyweight. Eats 400kg of food a day and sleeps the rest. A living roadblock — a Poké Flute is recommended.'],
            ['dex' => 94,  'name' => 'Gengar',      'type' => 'Ghost',    'hp' => 60,  'price' => 2800000, 'stock' => 0, 'best' => false, 'details' => 'Ghost/Poison-type. Hides in shadows and steals the warmth from whoever walks near. Rumored to be the shadow of a human on the wall.'],
            ['dex' => 150, 'name' => 'Mewtwo',      'type' => 'Psychic',  'hp' => 106, 'price' => 9999000, 'stock' => 1, 'best' => false, 'details' => 'Psychic-type legendary. A genetically engineered Pokémon created from the DNA of Mew. Exceptional power — handle with absolute respect.'],
            ['dex' => 149, 'name' => 'Dragonite',   'type' => 'Dragon',   'hp' => 91,  'price' => 4500000, 'stock' => 2, 'best' => false, 'details' => 'Dragon/Flying-type pseudo-legendary. Circles the globe in 16 hours and is said to rescue drowning sailors. Gentle giant.'],
            ['dex' => 501, 'name' => 'Oshawott',    'type' => 'Water',    'hp' => 55,  'price' => 1700000, 'stock' => 4, 'best' => false, 'details' => 'The Water-type starter of the Unova region. Uses the scalchop on its chest to crack berries and block attacks. Friendly and a little proud.'],
            ['dex' => 656, 'name' => 'Froakie',     'type' => 'Water',    'hp' => 41,  'price' => 1900000, 'stock' => 3, 'best' => false, 'details' => 'The Water-type starter of the Kalos region. Secretes bubbles from its chest and back to protect itself. Quiet, observant, and quick on its feet.'],
        ];

        foreach ($pokemons as $p) {
            Pokemon::create([
                'name'           => $p['name'],
                'type'           => $p['type'],
                'hp'             => $p['hp'],
                'price'          => $p['price'],
                'stock'          => $p['stock'],
                'details'        => $p['details'],
                'image_path'     => $artwork . $p['dex'] . '.png',
                'is_best_seller' => $p['best'],
            ]);
        }
    }
}
