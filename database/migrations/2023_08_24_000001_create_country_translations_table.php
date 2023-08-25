<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountryTranslationsTable extends Migration {

    public function up()
    {
        Schema::create('countries_translations', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name', 255);
            $table->unique(['country_id', 'locale']);
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::drop('countries_translations');
    }
}
