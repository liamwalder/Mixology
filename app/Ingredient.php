<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Ingredient
 * @package App
 */
class Ingredient extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name'];

}
