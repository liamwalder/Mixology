<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class AlcoholicFilter
 * @package App
 */
class AlcoholicFilter extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name'];

}
