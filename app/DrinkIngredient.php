<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class DrinkIngredient
 * @package App
 */
class DrinkIngredient extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'measure',
        'drink_id',
        'ingredient_id'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function drink()
    {
        return $this->belongsTo(Drink::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

}
