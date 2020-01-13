<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('autoId')->unique();
            $table->string('totalAmount')->default("0");
            $table->string('discountGiven')->default("0");
            $table->string('totalOrderAmount')->default("0");
            $table->string('paidAmount')->default("0");
            $table->string('balanceAmount')->default("0");
            $table->string('totalPoints')->default("0");
            $table->enum('paymentStatus',['pending', 'done'])->default('pending');
            $table->enum('orderStatus',['new', 'approved', 'cancelled', 'delivered'])->default('new');
            $table->text('deliveryAddress')->nullable(true);
            $table->text('comments')->nullable(true);
            $table->dateTimeTz('approvedDate')->nullable(true);
            $table->dateTimeTz('deliveredDate')->nullable(true);
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')
                ->references('id')->on('users');
            $table->unsignedBigInteger('sold_by');
            $table->foreign('sold_by')
                ->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
}
