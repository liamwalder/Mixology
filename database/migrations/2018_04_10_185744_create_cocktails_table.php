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
            $table->integer('drink_id');
            $table->text('data');
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
