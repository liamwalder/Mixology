<?php

namespace App\Repositories;
use App\Cocktail;
use App\Drink;
use App\Glass;
use Illuminate\Support\Facades\DB;

/**
 * Class DrinkRepository
 * @package App\Repositories
 */
class DrinkRepository
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        return Drink::all();
    }


    /**
     * @param array $filters
     * @return \Illuminate\Support\Collection
     */
    public function findAllFiltered(array $filters)
    {

        $drinksFilteredQuery = Drink::with(
            'glass',
            'category',
            'thumbnail',
            'alcoholicFilter',
            'drinkIngredients'
        );

        // Handle the ingredients filter.
        if (isset($filters['ingredients'])) {
            foreach ($filters['ingredients'] as $key => $ingredient) {
                $drinkIngredientsAlias = 'di' . $key;
                $drinksFilteredQuery->join(
                    DB::raw('drink_ingredients AS ' . $drinkIngredientsAlias),
                    DB::raw($drinkIngredientsAlias . '.drink_id'),
                    '=',
                    DB::raw('drinks.id AND ' . $drinkIngredientsAlias . '.ingredient_id = ' . $ingredient)
                );
            }
        }

        $drinksFilteredQuery->groupBy('drinks.id');

        return $drinksFilteredQuery->get();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        return Drink::where('name', $name)->first();
    }

}
