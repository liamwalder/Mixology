<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Ingredient;
use App\Repositories\IngredientRepository;
use App\Services\CocktailDB;
use Illuminate\Http\Request;

/**
 * Class IngredientController
 * @package App\Http\Controllers\Api
 */
class IngredientController extends Controller {

    /**
     * @param Request $request
     * @param IngredientRepository $ingredientRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIngredients(
        Request $request,
        IngredientRepository $ingredientRepository
    ) {
        $allIngredients = $ingredientRepository->getAllIngredients();
        $mostPopularIngredients = $ingredientRepository->getMostPopularIngredients();
        return response()->json([
            'all' => $allIngredients,
            'popular' => $mostPopularIngredients
        ]);
    }

    /**
     * @param Request $request
     * @param CocktailDB $cocktailDBService
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchIngredient(
        Request $request,
        CocktailDB $cocktailDBService
    ) {
        $cocktails = $cocktailDBService->searchIngredientByName($request->get('search'));
        return response()->json($cocktails);
    }

}