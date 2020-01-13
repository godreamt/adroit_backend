<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('autoId')->unique();
            $table->string('collectionAmount');
            $table->enum('paymentMethod', ['cash', 'cheque', 'demandDraft', 'neft', 'other']);
            $table->text('relatedInfo')->nullable(true);
            $table->enum('paymentStatus', ['processed', 'pending', 'cancelled']);
            $table->dateTimeTz('payProcessedDate')->nullable(true);
            $table->text('comments')->nullable(true);
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')
                ->references('id')->on('users');
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->unsignedBigInteger('collect_by');
            $table->foreign('collect_by')
                ->references('id')->on('users');
            $table->timestamps();
        });//conside check cash dd
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
}
