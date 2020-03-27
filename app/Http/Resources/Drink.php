<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Drink
 * @package App\Http\Resources
 */
class Drink extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'glass' => new Glass($this->glass),
            'instructions' => $this->instructions,
            'category' => new Category($this->category),
            'thumbnail' => new Thumbnail($this->thumbnail),
            'alcoholicFilter' => new AlcoholicFilter($this->alcoholicFilter),
            'ingredients' => new DrinkIngredientCollection($this->drinkIngredients)
        ];

    }
}
