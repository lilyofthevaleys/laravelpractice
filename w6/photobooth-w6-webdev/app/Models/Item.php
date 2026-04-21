<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    public const CATEGORIES = ['pokeball', 'berry', 'medicine', 'general'];

    public const CATEGORY_LABELS = [
        'pokeball' => 'Poké Balls',
        'berry'    => 'Berries',
        'medicine' => 'Medicines',
        'general'  => 'General Items',
    ];

    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'details',
        'image_path',
        'is_best_seller',
    ];

    protected $casts = [
        'is_best_seller' => 'boolean',
        'price'          => 'decimal:2',
    ];

    public function categoryLabel(): string
    {
        return self::CATEGORY_LABELS[$this->category] ?? ucfirst($this->category);
    }
}
