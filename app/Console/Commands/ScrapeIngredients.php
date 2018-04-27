<?php

namespace App\Console\Commands;

use App\Ingredient;
use App\Repositories\CocktailRepository;
use App\Services\Cocktail;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

/**
 * Class ScrapeIngredients
 * @package App\Console\Commands
 */
class ScrapeIngredients extends Command
{
    /**
     * @var string
     */
    protected $signature = 'scrape:ingredients';

    /**
     * @var string
     */
    protected $description = 'Scrape cocktails and ingredients.';

    /**
     * ScrapeIngredients constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Cocktail $cocktailService, Client $client, CocktailRepository $cocktailRepository)
    {
        $drinksIdRange = range(10000, 20000);

        $firstId = $drinksIdRange[0];
        $lastId = end($drinksIdRange);

        for ($i = $firstId; $i <= $lastId; $i++) {

            $this->info("Scraping drink ID $i");

            $response = $client->get("https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=$i");
            $result = json_decode($response->getBody(), true);

            $drink = $result['drinks'];

            if (!is_null($drink)) {

                $drink = $drink[0];


                /**
                 * Check to see if we have the cocktail saved and if we don't,
                 * we can save the cocktail.
                 */
                $drinkId = $drink['idDrink'];
                $cocktail = $cocktailRepository->getCocktailByDrinkId($drinkId);
                if (!$cocktail) {
                    $cocktailRepository->saveCocktail($drink);
                    $cocktail = $cocktailRepository->getCocktailByDrinkId($drinkId);
                }

                /**
                 * Extract and save ingredients
                 */
                $ingredients = $cocktailService->extractIngredients($drink);
                $ingredientsCount = count($ingredients);

                $this->info("Found $ingredientsCount ingredients");

                foreach ($ingredients as $ingredient) {
                    $ingredientByName = Ingredient::where('name', $ingredient)->first();

                    if (is_null($ingredientByName)) {
                        $newIngredient = new Ingredient();
                        $newIngredient->name = $ingredient;
                        $newIngredient->save();
                        $ingredientByName = $newIngredient;
                    }

                    if (!$cocktail->ingredients->contains($ingredientByName->id)) {
                        $cocktail->ingredients()->attach($ingredientByName);
                    }

                }


            } else {
                $this->error("Drunk $i not found");
            }

            $this->info('------------------------------------');

        }
    }
}
