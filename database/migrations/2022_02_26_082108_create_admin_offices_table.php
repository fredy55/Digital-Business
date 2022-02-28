<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_offices', function (Blueprint $table) {
            $table->id();
            $table->integer('office_id')->unsigned();
            $table->string('office_name');
            $table->string('email')->nullable();
            $table->string('phone_no');
            $table->string('address')->nullable();
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
        Schema::dropIfExists('admin_offices');
    }
}
