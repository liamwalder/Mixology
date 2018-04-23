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
