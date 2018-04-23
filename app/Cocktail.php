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
    protected $fillable = [
        'drink_id', 'data'
    ];

}
