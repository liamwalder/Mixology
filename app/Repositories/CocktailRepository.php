<?php

namespace App\Repositories;
use App\Cocktail;
use GuzzleHttp\Client;

/**
 * Class CocktailRepository
 * @package App\Services
 */
class CocktailRepository
{

    /**
     * @param $drinkId
     * @return mixed
     */
    public function getCocktailByDrinkId($drinkId)
    {
        return Cocktail::where('drink_id', $drinkId)->first();
    }


    /**
     * @param $cocktail
     */
    public function saveCocktail($cocktail)
    {
        $DBCocktail = new \App\Cocktail();
        $DBCocktail->fill([
            'drink_id' => $cocktail['idDrink'],
            'data' => json_encode($cocktail)
        ]);
        $DBCocktail->save();
    }

}
