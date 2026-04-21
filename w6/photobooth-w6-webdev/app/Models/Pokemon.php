<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pokemon extends Model
{
    use SoftDeletes;

    protected $table = 'pokemons';

    protected $fillable = [
        'name',
        'type',
        'hp',
        'price',
        'stock',
        'details',
        'image_path',
        'is_best_seller',
    ];

    protected $casts = [
        'is_best_seller' => 'boolean',
    ];
}
