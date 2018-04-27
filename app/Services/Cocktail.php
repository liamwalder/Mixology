<?php

namespace App\Services;
use App\Repositories\CocktailRepository;
use App\Transformers\CocktailTransformer;
use GuzzleHttp\Client;

/**
 * Class Cocktail
 * @package App\Services
 */
class Cocktail
{

    /**
     * @var CocktailDB
     */
    protected $cocktailDBService;

    /**
     * @var CocktailRepository
     */
    protected $cocktailRepository;

    /**
     * @var CocktailTransformer
     */
    protected $cocktailTransformer;

    /**
     * Cocktail constructor.
     * @param CocktailDB $cocktailDBService
     */
    public function __construct(
        CocktailDB $cocktailDBService,
        CocktailRepository $cocktailRepository,
        CocktailTransformer $cocktailTransformer
    ) {
        $this->cocktailDBService = $cocktailDBService;
        $this->cocktailRepository = $cocktailRepository;
        $this->cocktailTransformer = $cocktailTransformer;
    }


    /**
     * Check out database for the cocktail, if we can not find it we hit the API
     * to bring back the cocktail details. We can then store this in our database
     * for local cache.
     *
     * @param $drinkId
     * @return mixed
     */
    public function getCocktail($drinkId)
    {
        $cocktail = $this->cocktailRepository->getCocktailByDrinkId($drinkId);

        if (!$cocktail) {
            $cocktail = $this->cocktailDBService->getCocktail($drinkId)['drinks'][0];
            $this->cocktailRepository->saveCocktail($cocktail);
        } else {
            $cocktail = (array) json_decode($cocktail->data);
        }

        return $this->cocktailTransformer->transform($cocktail);
    }

    /**
     * @param $cocktails
     * @return array
     */
    public function collateCocktails($cocktails)
    {
        $collatedCocktails = [];

        foreach ($cocktails as $ingredient => $drinks) {
            foreach ($drinks as $drink) {

                $drinkId = $drink->drink_id;

                 /**
                  * First occurrence of drink
                  */
                if (!isset($collatedCocktails[$drinkId])) {
                    $occurrencesOfDrink = 1;
                }

                 /**
                  * If we already have the drink in our list
                  */
                if (isset($collatedCocktails[$drinkId])) {
                    $occurrencesOfDrink = $collatedCocktails[$drinkId]['numberOfIngredientsMatched'] + 1;
                }

                $cocktail = $this->getCocktail($drinkId);

                $collatedCocktails[$drinkId] = [
                    'cocktail' => $cocktail,
                    'numberOfIngredientsMatched' => $occurrencesOfDrink,
                    'matchPercentage' => (($occurrencesOfDrink / $cocktail['numberOfIngredients']) * 100)
                ];
            }
        }

        /**
         * Sorting so the highest number of ingredients match is at the top
         */
        usort($collatedCocktails, function($a, $b) {
            return $a['numberOfIngredientsMatched'] < $b['numberOfIngredientsMatched'];
        });

        return $collatedCocktails;
    }

    /**
     * @param $cocktail
     * @return array
     */
    public function extractIngredients($cocktail)
    {
        $ingredients = array_filter($cocktail, function ($key) {
            if (stripos($key, "strIngredient") !== false) {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY);

        $ingredients = array_filter($ingredients);
        $ingredients = array_values($ingredients);

        return $ingredients;
    }

}
