<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstName');
            $table->string('lastName')->nullable(true);
            $table->string('email')->unique();
            $table->string('mobileNumber')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('reset_token')->nullable(true);
            $table->text('address')->nullable(true);
            $table->boolean('isActive')->default(true);
            $table->enum('roles', ['admin', 'country_head', 'state_head', 'regional_head', 'sales_executive', 'vendors'])->default('admin');
            $table->float('monthlySalary')->default(0.0);
            $table->float('salesTarget')->default(0.0);
            $table->float('collectionTarget')->default(0.0);
            $table->string('vendorBalanceAmount')->default("0");
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
