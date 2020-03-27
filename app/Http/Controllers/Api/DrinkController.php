<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DrinkCollection;
use App\Http\Resources\DrinkCollectionResource;
use App\Http\Resources\DrinkResource;
use App\Repositories\DrinkRepository;
use App\Repositories\IngredientRepository;
use App\Services\Cocktail;
use App\Services\CocktailDB;
use Illuminate\Http\Request;

/**
 * Class DrinkController
 * @package App\Http\Controllers\Api
 */
class DrinkController extends Controller
{

    /**
     * @param DrinkRepository $drinkRepository
     * @return DrinkCollection
     */
    public function list(DrinkRepository $drinkRepository)
    {
        $drinks = $drinkRepository->findAll();
        return new DrinkCollection($drinks);
    }

    /**
     * @param Request $request
     * @param DrinkRepository $drinkRepository
     * @return DrinkCollection
     */
    public function filtered(Request $request, DrinkRepository $drinkRepository)
    {
        $data = $request->json()->all();

        $filters = [
            'ingredients' => $data['ingredients']
        ];

        $drinks = $drinkRepository->findAllFiltered($filters);
        return new DrinkCollection($drinks);
    }

}