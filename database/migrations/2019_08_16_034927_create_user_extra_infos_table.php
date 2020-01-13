<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserExtraInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_extra_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fatherName')->nullable(true);
            $table->string('motherName')->nullable(true);
            $table->string('alternativeMobileNumber')->nullable(true);
            $table->string('alternativeEmail')->nullable(true);
            $table->text('alternativeAddress')->nullable(true); 
            $table->enum('maritalStatus', ['married', 'unmarried'])->default('unmarried');
            $table->string('panNumber')->nullable(true);
            $table->string('adharNumber')->nullable(true);
            $table->string('drivingLicence')->nullable(true);
            $table->dateTimeTz('dateOfBirth')->nullable(true);
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_extra_infos');
    }
}
