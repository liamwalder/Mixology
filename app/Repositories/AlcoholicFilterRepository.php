<?php

namespace App\Repositories;
use App\AlcoholicFilter;
use App\Cocktail;
use App\Ingredient;
use GuzzleHttp\Client;

/**
 * Class AlcoholicFilterRepository
 * @package App\Repositories
 */
class AlcoholicFilterRepository
{

    /**
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        return AlcoholicFilter::where('name', $name)->first();
    }

}
