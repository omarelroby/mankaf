<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration {

    public function up()
    {
        Schema::create('countries', function(Blueprint $table) {
            $table->increments('id');
            $table->string('image', 255);
            $table->string('country_code', 255);
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::drop('countries');
    }
}
