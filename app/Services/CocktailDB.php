<?php

namespace App\Services;
use GuzzleHttp\Client;

/**
 * Class CocktailDB
 * @package App\Service
 */
class CocktailDB
{

    /**
     * @var Client
     */
    public $client;

    /**
     * @var string
     */
    public $baseUrl = 'https://www.thecocktaildb.com/api/json/v1/1/';

    /**
     * CocktailDB constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        $response = $this->client->get($this->baseUrl . "list.php?c=list");
        return json_decode($response->getBody(), true);
    }

    /**
     * @return mixed
     */
    public function getGlasses()
    {
        $response = $this->client->get($this->baseUrl . "list.php?g=list");
        return json_decode($response->getBody(), true);
    }

    /**
     * @return mixed
     */
    public function getIngredients()
    {
        $response = $this->client->get($this->baseUrl . "list.php?i=list");
        return json_decode($response->getBody(), true);
    }

    /**
     * @return mixed
     */
    public function getAlcoholFilters()
    {
        $response = $this->client->get($this->baseUrl . "list.php?a=list");
        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $ingredient
     * @return mixed
     */
    public function getDrinksByIngredient(string $ingredient)
    {
        $response = $this->client->get($this->baseUrl . "filter.php?i=" . $ingredient);
        return json_decode($response->getBody(), true);
    }

    /**
     * @param $drinkId
     * @return mixed
     */
    public function getDrink($drinkId)
    {
        $response = $this->client->get($this->baseUrl . "lookup.php?i=" . $drinkId);
        return json_decode($response->getBody(), true);
    }

    /**
     * @param $query
     * @return string
     */
    public function searchCocktailByName($query)
    {
        $response = $this->client->get($this->baseUrl . "search.php?s=$query");
        return json_decode($response->getBody(), true);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function searchIngredientByName($query)
    {
        $response = $this->client->get($this->baseUrl . "search.php?i=$query");
        return json_decode($response->getBody(), true);
    }

    /**
     * @param $cocktailId
     * @return mixed
     */
    public function getCocktail($cocktailId)
    {
        $response = $this->client->get($this->baseUrl . "lookup.php?i=$cocktailId");
        return json_decode($response->getBody(), true);
    }

    /**
     * @param $ingredientName
     * @return mixed
     */
    public function getCocktailsByIngredient($ingredientName)
    {
        $response = $this->client->get($this->baseUrl . "filter.php?i=$ingredientName");
        return json_decode($response->getBody(), true);
    }

    /**
     * @return mixed
     */
    public function getRandomCocktail()
    {
        $response = $this->client->get($this->baseUrl . "random.php");
        return json_decode($response->getBody(), true);
    }


}
