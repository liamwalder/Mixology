<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCocktailIngredientTable
 */
class CreateCocktailIngredientTable extends Migration
{
    /**
     *
     */
    public function up()
    {
        Schema::create('cocktail_ingredient', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cocktail_id');
            $table->integer('ingredient_id');
        });
    }

    /**
     *
     */
    public function down()
    {
        Schema::dropIfExists('cocktail_ingredient');
    }
}
