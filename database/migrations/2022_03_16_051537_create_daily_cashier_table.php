<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyCashierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_cashier', function (Blueprint $table) {
            $table->id();
            $table->integer('office_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('account');
            $table->integer('IsActive')->default(1);
            $table->string('date_created');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_cashier');
    }
}
