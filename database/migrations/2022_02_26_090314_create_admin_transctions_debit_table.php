<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTransctionsDebitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_transctions_debit', function (Blueprint $table) {
            $table->id();
            $table->integer('office_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('transaction_id')->unsigned();
            $table->string('benefitiary');
            $table->decimal('amount', 8, 2);
            $table->decimal('commission', 8, 2);
            $table->string('type');
            $table->text('description');
            $table->string('evidence_url');
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
        Schema::dropIfExists('admin_transctions_debit');
    }
}
