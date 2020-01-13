<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMonthlyTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_monthly_targets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->integer('month');
            $table->integer('year');
            $table->string('salesTarget')->default(0.0);
            $table->string('collectionTarget')->default(0.0);
            $table->string('salesTargetReached')->default(0.0);
            $table->string('collectionTargetReached')->default(0.0);
            $table->string('collectedPoints')->default(0.0);
            $table->string('basicSalary')->default(0.0);
            $table->string('expenseAmount')->default(0.0);
            $table->string('salaryPaid')->default(0.0);
            $table->string('keptAmount')->default(0.0);
            $table->unique(['user_id', 'month', 'year'], 'user_target_unique');
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
        Schema::dropIfExists('user_monthly_targets');
    }
}
