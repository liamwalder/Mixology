<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Category
 * @package App
 */
class Category extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name'];

}
