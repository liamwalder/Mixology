<?php

namespace App\Repositories;
use App\Cocktail;
use App\Ingredient;
use GuzzleHttp\Client;

/**
 * Class IngredientRepository
 * @package App\Repositories
 */
class IngredientRepository
{

    /**
     * @return mixed
     */
    public function findAll()
    {
        return Ingredient::orderBy('name', 'ASC')->get();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        return Ingredient::where('name', $name)->first();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getMostPopularIngredients($limit = 25)
    {
        return \DB::select("
            SELECT i.id, i.name FROM cocktail_ingredient ci
            LEFT JOIN ingredients i ON i.id = ci.ingredient_id
            GROUP BY ingredient_id
            ORDER BY COUNT(ingredient_id) DESC
            LIMIT $limit
        ");
    }


    /**
     * @param $ingredient
     * @return mixed
     */
    public function getIngredient($ingredient)
    {
        return Ingredient::findOrFail($ingredient);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getIngredientByName($name)
    {
        return Ingredient::where('name', $name)->first();
    }

}
