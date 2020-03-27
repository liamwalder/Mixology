<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DrinkIngredient
 * @package App\Http\Resources
 */
class DrinkIngredient extends JsonResource
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
            'measure' => $this->measure,
            'ingredient' => new Ingredient($this->ingredient)
        ];

    }
}
