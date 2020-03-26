<?php

namespace App\Repositories;
use App\Cocktail;
use App\Drink;
use App\Glass;

/**
 * Class DrinkRepository
 * @package App\Repositories
 */
class DrinkRepository
{

    /**
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        return Drink::where('name', $name)->first();
    }

}
