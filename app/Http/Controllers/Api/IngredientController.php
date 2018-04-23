<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $ingredients = $ingredientRepository->getAllIngredients();
        return response()->json($ingredients);
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