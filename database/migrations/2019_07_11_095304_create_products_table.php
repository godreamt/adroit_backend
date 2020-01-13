<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique(true);
            $table->text('shortDescription')->nullable(true);
            $table->text('description')->nullable(true);
            $table->text('featureInfo')->nullable(true);
            $table->decimal('offerPrice', 8, 2);
            $table->decimal('regularPrice', 8, 2);
            $table->decimal('salesPoints', 8, 2);
            $table->string('featuredImage');
            $table->boolean('removeFromList')->default(false);
            $table->boolean('bestSeller')->default(false);
            $table->unsignedInteger('sub_category_id');
            $table->foreign('sub_category_id')
                ->references('id')->on('sub_categories')
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
        Schema::dropIfExists('products');
    }
}
