<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateDrinksTable
 */
class CreateDrinksTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('drinks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('instructions');
            $table->integer('category_id');
            $table->integer('alcoholic_filter_id')->nullable();
            $table->integer('glass_id');
            $table->integer('thumbnail_id');
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
        Schema::dropIfExists('drinks');
    }
}
