<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTransctionsMainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_transctions_main', function (Blueprint $table) {
            $table->id();
            $table->integer('office_id')->unsigned();
            $table->integer('transaction_id')->unsigned();
            $table->decimal('funded', 8, 2)->nullable();
            $table->decimal('top_ups', 8, 2)->nullable();
            $table->decimal('drop_money', 8, 2)->nullable();
            $table->decimal('collected', 8, 2)->nullable();
            $table->decimal('expenses', 8, 2)->nullable();
            $table->decimal('winnings_paid', 8, 2)->nullable();
            $table->decimal('deposit', 8, 2)->nullable();
            $table->decimal('deposit_commission', 8, 2)->nullable();
            $table->decimal('pos', 8, 2)->nullable();
            $table->decimal('pos_commission', 8, 2)->nullable();
            $table->decimal('bank_transfers', 8, 2)->nullable();
            $table->decimal('btransfer_commission', 8, 2)->nullable();
            $table->decimal('sales', 8, 2)->nullable();
            $table->decimal('old_sales', 8, 2)->nullable();
            $table->decimal('closing', 8, 2)->nullable();
            $table->decimal('cash_at_hand', 8, 2)->nullable();
            $table->integer('IsActive')->default(0);
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
        Schema::dropIfExists('admin_transctions_main');
    }
}
