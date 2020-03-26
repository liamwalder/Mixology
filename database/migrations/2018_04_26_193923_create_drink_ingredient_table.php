<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateDrinkIngredientTable
 */
class CreateDrinkIngredientTable extends Migration
{
    /**
     *
     */
    public function up()
    {
        Schema::create('drink_ingredients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('measure')->nullable();
            $table->integer('drink_id');
            $table->integer('ingredient_id');
            $table->timestamps();
        });
    }

    /**
     *
     */
    public function down()
    {
        Schema::dropIfExists('drink_ingredients');
    }
}
