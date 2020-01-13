<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_trackers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable(true);
            $table->string('expenseAmount');
            $table->string('allocatedAmount')->nullable(true);
            $table->dateTimeTz('expenseDate');
            $table->string('documentImage')->nullable(true);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->enum('status', ['requested', 'approved', 'cancelled']);
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
        Schema::dropIfExists('expense_trackers');
    }
}
