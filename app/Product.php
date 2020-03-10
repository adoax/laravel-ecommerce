<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['title', 'slug', 'excerpt', 'description', 'price', 'image'];

    /**
     * Permet de recuperer le prix en format français
     *
     * @return string
     */
    public function getPrice()
    {
        $price = $this->price / 100;
        return number_format($price, 2, ',', ' ') . '€';
    }

    /**
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
