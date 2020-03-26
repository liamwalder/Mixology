<?php

namespace App\Console\Commands;

use App\AlcoholicFilter;
use App\Category;
use App\Drink;
use App\DrinkIngredient;
use App\Glass;
use App\Ingredient;
use App\Repositories\AlcoholicFilterRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\DrinkRepository;
use App\Repositories\GlassRepository;
use App\Repositories\IngredientRepository;
use App\Services\CocktailDB;
use App\Thumbnail;
use Illuminate\Console\Command;

/**
 * Class ScrapeCocktailDB
 * @package App\Console\Commands
 */
class ScrapeCocktailDB extends Command
{

    /**
     * @var CocktailDB
     */
    protected $cocktailDb;

    /**
     * @var IngredientRepository
     */
    protected $ingredientRepository;

    /**
     * @var GlassRepository
     */
    protected $glassRepository;

    /**
     * @var DrinkRepository
     */
    protected $drinkRepository;

    /**
     * @var AlcoholicFilterRepository
     */
    protected $alcoholicFilterRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var string
     */
    protected $signature = 'scrape:cocktaildb';

    /**
     * @var string
     */
    protected $description = 'Pull data from Cocktail DB.';

    /**
     * ScrapeCocktailDB constructor.
     * @param CocktailDB $cocktailDb
     * @param IngredientRepository $ingredientRepository
     * @param GlassRepository $glassRepository
     * @param DrinkRepository $drinkRepository
     * @param CategoryRepository $categoryRepository
     * @param AlcoholicFilterRepository $alcoholicFilterRepository
     */
    public function __construct(
        CocktailDB $cocktailDb,
        GlassRepository $glassRepository,
        DrinkRepository $drinkRepository,
        CategoryRepository $categoryRepository,
        IngredientRepository $ingredientRepository,
        AlcoholicFilterRepository $alcoholicFilterRepository
    ) {
        parent::__construct();


        $this->cocktailDb = $cocktailDb;
        $this->glassRepository = $glassRepository;
        $this->drinkRepository = $drinkRepository;
        $this->categoryRepository = $categoryRepository;
        $this->ingredientRepository = $ingredientRepository;
        $this->alcoholicFilterRepository = $alcoholicFilterRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $this->saveCategories();
//        $this->saveGlasses();
//        $this->saveIngredients();
//        $this->saveAlcoholicFilters();
        $this->scrapeDrinks();
    }

    protected function scrapeDrinks()
    {
        $ingredients = $this->ingredientRepository->findAll();
        $ingredientsCount = $ingredients->count();
        $this->info('Found ' . $ingredientsCount . ' ingredients.');
        $this->line('');

        $ingredientsIncrementCount = 0;
        foreach ($ingredients as $ingredient) {
            $ingredientsIncrementCount++;

            $drinksByIngredient = $this->cocktailDb->getDrinksByIngredient($ingredient->name);
            if ($drinksByIngredient) {

                $drinksByIngredientCount = count($drinksByIngredient['drinks']);
                $this->info('[' . $ingredientsIncrementCount .'/' . $ingredientsCount . '] Scraping ' . $drinksByIngredientCount . ' drinks for `' . $ingredient->name . '`.');

                $drinksByIngredientIncrementCount = 0;
                foreach ($drinksByIngredient['drinks'] as $ingredientDrink) {

                    $drinksByIngredientIncrementCount++;

                    $drink = $this->cocktailDb->getDrink($ingredientDrink['idDrink']);
                    $drink = $drink['drinks'][0];

                    // If we don't already have knowledge of this drink, lets scrape it.
                    $existingDrink = $this->drinkRepository->findByName($drink['strDrink']);
                    if (!$existingDrink) {

                        $this->info('[' . $drinksByIngredientIncrementCount . '/' . $drinksByIngredientCount . '] Scraping `' . $drink['strDrink'] . '`.');

                        $drinkEntityData = [
                            'name' => $drink['strDrink'],
                            'cocktail_db_id' => $drink['idDrink'],
                            'instructions' => $drink['strInstructions']
                        ];

                        // Find and associate the glass.
                        $glass = null;
                        if (isset($drink['strGlass']) && !is_null($drink['strGlass'])) {
                            $glass = $this->glassRepository->findByName($drink['strGlass']);
                        }
                        if ($glass) {
                            $drinkEntityData['glass_id'] = $glass->id;
                        }

                        // Find and associate the category.
                        $category = null;
                        if (isset($drink['strCategory']) && !is_null($drink['strCategory'])) {
                            $category = $this->categoryRepository->findByName($drink['strCategory']);
                        }
                        if ($category) {
                            $drinkEntityData['category_id'] = $category->id;
                        }

                        // Find and associate the alcoholic filter.
                        $alcoholicFilter = null;
                        if (isset($drink['strAlcoholic']) && !is_null($drink['strAlcoholic'])) {
                            $alcoholicFilter = $this->alcoholicFilterRepository->findByName($drink['strAlcoholic']);
                        }
                        if ($alcoholicFilter) {
                            $drinkEntityData['alcoholic_filter_id'] = $alcoholicFilter->id;
                        }

                        // Create and attach the thumbnail
                        if ($drink['strDrinkThumb']) {
                            $thumbnail = new Thumbnail();
                            $thumbnail->fill(['url' => $drink['strDrinkThumb']]);
                            $thumbnail->save();
                            $thumbnail->fresh();
                            $drinkEntityData['thumbnail_id'] = $thumbnail->id;
                        }

                        $drinkEntity = new Drink();
                        $drinkEntity->fill($drinkEntityData);
                        $drinkEntity->save();

                        // Build drink ingredients list.
                        $drinkIngredients = [];
                        foreach($drink as $key => $value) {
                            if (preg_match('/strIngredient[0-9]/', $key)){
                                $drinkIngredients[] = $value;
                            }
                        }
                        $drinkIngredients = array_filter($drinkIngredients);

                        // Build drink measures list.
                        $drinkIngredientMeasures = [];
                        foreach($drink as $key => $value) {
                            if (preg_match('/strMeasure[0-9]/', $key)){
                                $drinkIngredientMeasures[] = $value;
                            }
                        }
                        $drinkIngredientMeasures = array_filter($drinkIngredientMeasures);

                        // Save drink ingredients
                        foreach ($drinkIngredients as $drinkIngredientKey => $drinkIngredient) {

                            $ingredient = $this->ingredientRepository->findByName($drinkIngredient);
                            if ($ingredient) {

                                $drinkIngredientEntity = new DrinkIngredient();
                                $drinkIngredientEntity->fill([
                                    'drink_id' => $drinkEntity->id,
                                    'ingredient_id' => $ingredient->id,
                                    'measure' => isset($drinkIngredientMeasures[$drinkIngredientKey]) ? $drinkIngredientMeasures[$drinkIngredientKey] : null
                                ]);
                                $drinkIngredientEntity->save();

                            } else {

                                $ingredientEntity = new Ingredient();
                                $ingredientEntity->fill(['name' => $drinkIngredient]);
                                $ingredientEntity->save();
                                $ingredientEntity->fresh();

                                $drinkIngredientEntity = new DrinkIngredient();
                                $drinkIngredientEntity->fill([
                                    'drink_id' => $drinkEntity->id,
                                    'ingredient_id' => $ingredientEntity->id,
                                    'measure' => isset($drinkIngredientMeasures[$drinkIngredientKey]) ? $drinkIngredientMeasures[$drinkIngredientKey] : null
                                ]);
                                $drinkIngredientEntity->save();

                            }
                        }

                        sleep(rand(1, 10));

                    } else {
                        $this->error('[' . $drinksByIngredientIncrementCount . '/' . $drinksByIngredientCount . '] `' . $drink['strDrink'] . '` has already been scraped.');
                    }

                }

            }

            $this->line('');

        }
    }


    protected function saveCategories()
    {
        $categories = $this->cocktailDb->getCategories();
        foreach ($categories['drinks'] as $category) {
            if (!is_null($category['strCategory'])) {
                $categoryEntity = new Category();
                $categoryEntity->fill(['name' => $category['strCategory']]);
                $categoryEntity->save();
            }
        }
    }

    protected function saveGlasses()
    {
        $glasses = $this->cocktailDb->getGlasses();
        foreach ($glasses['drinks'] as $glass) {
            if (!is_null($glass['strGlass'])) {
                $glassEntity = new Glass();
                $glassEntity->fill(['name' => $glass['strGlass']]);
                $glassEntity->save();
            }
        }
    }

    protected function saveIngredients()
    {
        $ingredients = $this->cocktailDb->getIngredients();
        foreach ($ingredients['drinks'] as $ingredient) {
            if (!is_null($ingredient['strIngredient1'])) {
                $ingredientEntity = new Ingredient();
                $ingredientEntity->fill(['name' => $ingredient['strIngredient1']]);
                $ingredientEntity->save();
            }
        }
    }

    protected function saveAlcoholicFilters()
    {
        $alcoholicFilters = $this->cocktailDb->getAlcoholFilters();
        foreach ($alcoholicFilters['drinks'] as $alcoholicFilter) {
            if (!is_null($alcoholicFilter['strAlcoholic'])) {
                $ingredientEntity = new AlcoholicFilter();
                $ingredientEntity->fill(['name' => $alcoholicFilter['strAlcoholic']]);
                $ingredientEntity->save();
            }
        }
    }


}
