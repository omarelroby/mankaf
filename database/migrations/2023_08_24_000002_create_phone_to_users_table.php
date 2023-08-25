<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneToUsersTable extends Migration {

    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->boolean('verify')->default(0)->after('password');
            $table->text('phone')->after('verify');
            $table->text('confirmation_code')->after('verify')->nullable();
            $table->text('firebase_token')->after('verify')->nullable();
            $table->text('image')->after('verify')->nullable();
            $table->unsignedInteger('country_id')->after('verify');
            $table->unique(['country_id']);
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');


        });
    }
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn([
                'verify',
                'phone',
                'confirmation_code',
                'firebase_token',
                'country_id',
                'image',

            ]);
        });
    }
}
