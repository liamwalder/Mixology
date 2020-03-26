<?php

namespace App\Repositories;
use App\Cocktail;
use App\Glass;

/**
 * Class GlassRepository
 * @package App\Repositories
 */
class GlassRepository
{

    /**
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        return Glass::where('name', $name)->first();
    }

}
