<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Drink
 * @package App
 */
class Drink extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'glass_id',
        'category_id',
        'instructions',
        'thumbnail_id',
        'cocktail_db_id',
        'alcoholic_filter_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function drinkIngredients()
    {
        return $this->hasMany(DrinkIngredient::class, 'drink_id', 'drink_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function glass()
    {
        return $this->belongsTo(Glass::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alcoholicFilter()
    {
        return $this->belongsTo(AlcoholicFilter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thumbnail()
    {
        return $this->belongsTo(Thumbnail::class);
    }

}
