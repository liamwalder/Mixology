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
     * @param $drinkId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllIngredients()
    {
        return Ingredient::orderBy('name', 'ASC')->get();
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
