<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAlter extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('country_id')->nullable(true);
            $table->foreign('country_id')
                    ->references('id')->on('countries');
            $table->unsignedInteger('state_id')->nullable(true);
            $table->foreign('state_id')
                    ->references('id')->on('states');
            $table->unsignedInteger('region_id')->nullable(true);
            $table->foreign('region_id')
                    ->references('id')->on('regions');
            $table->unsignedInteger('area_id')->nullable(true);
            $table->foreign('area_id')
                    ->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
