<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTransctionsTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_transctions_totals', function (Blueprint $table) {
            $table->id();
            $table->integer('office_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->decimal('funded', 8, 2);
            $table->decimal('top_ups', 8, 2);
            $table->decimal('drop_money', 8, 2);
            $table->decimal('sales', 8, 2);
            $table->decimal('closing', 8, 2);
            $table->decimal('cash_at_hand', 8, 2);
            $table->integer('IsActive')->default(1);
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
        Schema::dropIfExists('admin_transctions_totals');
    }
}
