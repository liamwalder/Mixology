<?php

namespace App\Transformers;
use App\Repositories\IngredientRepository;

/**
 * Class CocktailRepository
 * @package App\Services
 */
class CocktailTransformer
{

    /**
     * @var IngredientRepository
     */
    protected $ingredientRepository;

    /**
     * CocktailTransformer constructor.
     * @param IngredientRepository $ingredientRepository
     */
    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    /**
     * @param $cocktail
     * @return array
     */
   public function transform($cocktail)
   {
        $measures = $this->extractMeasures($cocktail);
        $ingredients = $this->extractIngredients($cocktail);

        return [
            'id' => $cocktail['idDrink'],
            'name' => $cocktail['strDrink'],
            'video' => $cocktail['strVideo'],
            'category' => $cocktail['strCategory'],
            'thumbnail' => $cocktail['strDrinkThumb'],
            'numberOfIngredients' => count($ingredients),
            'instructions' => $cocktail['strInstructions'],
            'ingredients' => $this->mergeIngredientsAndMeasures($ingredients, $measures)
        ];
   }


    /**
     * @param array $ingredients
     * @param array $measures
     * @return array
     */
   protected function mergeIngredientsAndMeasures(array $ingredients, array $measures)
   {
       $mergedIngredientsAndMeasures = [];

       for ($i = 0; $i < count($ingredients); $i++) {
           $mergedIngredientsAndMeasures[] = [
               'id' => $ingredients[$i]['id'],
               'name' => $ingredients[$i]['name'],
               'measure' => isset($measures[$i]) ? $measures[$i] : ''
           ];
       }

       return $mergedIngredientsAndMeasures;
   }



    /**
     * @param $cocktail
     * @return array
     */
   protected function extractMeasures($cocktail)
   {
       $measures = array_filter($cocktail, function ($key) {
           if (stripos($key, "strMeasure") !== false) {
               return true;
           }
       }, ARRAY_FILTER_USE_KEY);

       $measures = array_map('trim', $measures);
       $measures = array_filter($measures);
       $measures = array_values($measures);

       return $measures;
   }


    /**
     * @param $cocktail
     * @return array
     */
   protected function extractIngredients($cocktail)
   {
       $ingredients = array_filter($cocktail, function ($key) {
           if (stripos($key, "strIngredient") !== false) {
               return true;
           }
       }, ARRAY_FILTER_USE_KEY);

       $ingredients = array_filter($ingredients);
       $ingredients = array_values($ingredients);

       $responseIngredients = [];
       foreach ($ingredients as $ingredient) {
           $ingredient = $this->ingredientRepository->getIngredientByName($ingredient);
           $responseIngredients[] = [
               'id' => $ingredient->id,
               'name' => $ingredient->name
           ];
       }

       return $responseIngredients;
   }

}
