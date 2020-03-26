<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCocktailsTable
 */
class CreateCocktailsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('cocktails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('instructions');
            $table->integer('category_id');
            $table->integer('alcoholic_filter_id');
            $table->integer('glass_id');
            $table->integer('cocktail_db_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cocktails');
    }
}
