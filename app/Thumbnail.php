<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Thumbnail
 * @package App
 */
class Thumbnail extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'url',
        'drink_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function drinks()
    {
        return $this->hasMany(Drink::class);
    }

}
