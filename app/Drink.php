<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class Cocktail extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name', 'instructions', 'category_id', 'alcoholic_filter_id', 'glass_id', 'cocktail_db_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }

}
