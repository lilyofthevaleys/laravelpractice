<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $sprites = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/';

        $items = [
            // Poké Balls
            ['name' => 'Poké Ball',     'category' => 'pokeball', 'price' => 20000,  'stock' => 50, 'details' => 'A device for catching wild Pokémon. It\'s thrown like a ball and stores the Pokémon inside.',        'sprite' => 'poke-ball.png',   'best' => true],
            ['name' => 'Great Ball',    'category' => 'pokeball', 'price' => 60000,  'stock' => 30, 'details' => 'A good, high-performance Poké Ball. Has a higher catch rate than a standard Poké Ball.',              'sprite' => 'great-ball.png',  'best' => true],
            ['name' => 'Ultra Ball',    'category' => 'pokeball', 'price' => 120000, 'stock' => 20, 'details' => 'An ultra-performance Poké Ball. Much more effective at catching hard-to-catch Pokémon.',                 'sprite' => 'ultra-ball.png',  'best' => false],
            ['name' => 'Master Ball',   'category' => 'pokeball', 'price' => 999000, 'stock' => 1,  'details' => 'The best Poké Ball in existence. Catches any wild Pokémon without fail.',                                  'sprite' => 'master-ball.png', 'best' => true],

            // Berries
            ['name' => 'Oran Berry',    'category' => 'berry',    'price' => 15000,  'stock' => 80, 'details' => 'A Berry to be consumed by Pokémon. Restores 10 HP when held.',                                                'sprite' => 'oran-berry.png',   'best' => true],
            ['name' => 'Sitrus Berry',  'category' => 'berry',    'price' => 30000,  'stock' => 40, 'details' => 'A Berry to be consumed by Pokémon. Restores about a quarter of max HP when the holder\'s HP is low.',         'sprite' => 'sitrus-berry.png', 'best' => false],
            ['name' => 'Lum Berry',     'category' => 'berry',    'price' => 45000,  'stock' => 35, 'details' => 'A Berry that cures any status condition (sleep, poison, paralysis, burn, freeze) when held.',                'sprite' => 'lum-berry.png',    'best' => true],
            ['name' => 'Leppa Berry',   'category' => 'berry',    'price' => 35000,  'stock' => 25, 'details' => 'A Berry that restores the PP of one of the holder\'s moves.',                                                  'sprite' => 'leppa-berry.png',  'best' => false],

            // Medicines
            ['name' => 'Potion',        'category' => 'medicine', 'price' => 25000,  'stock' => 60, 'details' => 'A spray medicine for wounds. Restores 20 HP to one Pokémon.',                                                  'sprite' => 'potion.png',       'best' => true],
            ['name' => 'Super Potion',  'category' => 'medicine', 'price' => 70000,  'stock' => 40, 'details' => 'A spray medicine for wounds. Restores 60 HP to one Pokémon.',                                                  'sprite' => 'super-potion.png', 'best' => false],
            ['name' => 'Hyper Potion',  'category' => 'medicine', 'price' => 150000, 'stock' => 20, 'details' => 'A spray medicine for serious wounds. Restores 120 HP to one Pokémon.',                                         'sprite' => 'hyper-potion.png', 'best' => true],
            ['name' => 'Full Restore',  'category' => 'medicine', 'price' => 300000, 'stock' => 10, 'details' => 'A medicine that fully restores the HP and heals any status conditions of one Pokémon.',                       'sprite' => 'full-restore.png', 'best' => false],
            ['name' => 'Revive',        'category' => 'medicine', 'price' => 200000, 'stock' => 15, 'details' => 'A medicine that revives a fainted Pokémon, restoring half its max HP.',                                        'sprite' => 'revive.png',       'best' => true],

            // General Items
            ['name' => 'Escape Rope',   'category' => 'general',  'price' => 55000,  'stock' => 25, 'details' => 'A long, durable rope. Use it to escape instantly from a cave or dungeon.',                                     'sprite' => 'escape-rope.png',  'best' => false],
            ['name' => 'Repel',         'category' => 'general',  'price' => 35000,  'stock' => 50, 'details' => 'An item that prevents weak wild Pokémon from appearing for 100 steps.',                                        'sprite' => 'repel.png',        'best' => true],
            ['name' => 'Rare Candy',    'category' => 'general',  'price' => 500000, 'stock' => 5,  'details' => 'A candy packed with energy. When consumed, raises the level of a single Pokémon by one.',                     'sprite' => 'rare-candy.png',   'best' => true],
            ['name' => 'Poké Doll',     'category' => 'general',  'price' => 100000, 'stock' => 20, 'details' => 'A doll that attracts Pokémon. Use it to flee from any wild Pokémon battle without fail.',                      'sprite' => 'poke-doll.png',    'best' => false],
            ['name' => 'Exp. Share',    'category' => 'general',  'price' => 400000, 'stock' => 8,  'details' => 'A device that distributes battle experience to all Pokémon in the party, even those that didn\'t fight.',     'sprite' => 'exp-share.png',    'best' => false],
        ];

        foreach ($items as $item) {
            Item::create([
                'name'           => $item['name'],
                'category'       => $item['category'],
                'price'          => $item['price'],
                'stock'          => $item['stock'],
                'details'        => $item['details'],
                'image_path'     => $sprites . $item['sprite'],
                'is_best_seller' => $item['best'],
            ]);
        }
    }
}
