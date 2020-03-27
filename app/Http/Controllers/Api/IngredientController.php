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
     * @param IngredientRepository $ingredientRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(IngredientRepository $ingredientRepository)
    {
        $ingredients = $ingredientRepository->findAll();

        return response()->json([
            'ingredients' => $ingredients
        ]);
    }

}