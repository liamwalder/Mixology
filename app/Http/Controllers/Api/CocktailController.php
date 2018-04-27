<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\IngredientRepository;
use App\Services\Cocktail;
use App\Services\CocktailDB;
use Illuminate\Http\Request;

/**
 * Class CocktailController
 * @package App\Http\Controllers\Api
 */
class CocktailController extends Controller
{

    /**
     * @param Request $request
     * @param CocktailDB $cocktailDBService
     * @param Cocktail $cocktailService
     */
    public function getCocktails(
        Request $request,
        CocktailDB $cocktailDBService,
        Cocktail $cocktailService,
        IngredientRepository $ingredientRepository
    )
    {
        $cocktailsByIngredients = [];

        foreach ($request->get('ingredients') as $ingredient) {
            $ingredient = $ingredientRepository->getIngredient($ingredient);
            $cocktailsByIngredients[$ingredient->name] = $ingredient->cocktails;
        }

        $cocktails = $cocktailService->collateCocktails($cocktailsByIngredients);

        return response()->json($cocktails);
    }

}