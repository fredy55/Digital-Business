<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentregsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agentregs', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('dob');
            $table->string('gender');
            $table->string('shop_address');
            $table->string('state');
            $table->string('lga');
            $table->string('landmark');
            $table->string('ref_chan');
            $table->string('indoor_img_location');
            $table->string('outdoor_img_location');
            $table->string('reg_date');
            $table->string('status')->default('Active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agentregs');
    }
}
