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
    protected $fillable = ['name', 'instructions', 'category_id', 'alcoholic_filter_id', 'glass_id', 'thumbnail_id', 'cocktail_db_id'];

}
