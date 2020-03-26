<?php

namespace App\Repositories;
use App\Category;
use App\Cocktail;

/**
 * Class CategoryRepository
 * @package App\Repositories
 */
class CategoryRepository
{

    /**
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        return Category::where('name', $name)->first();
    }

}
