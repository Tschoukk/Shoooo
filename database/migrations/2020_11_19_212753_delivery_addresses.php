<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeliveryAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_addresses', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->index('user_id');
            $table->string('user_email');
            $table->string('name', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('pincode', 25)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('mobile', 25)->nullable(); 
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
        Schema::table('delivery_addresses',function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on ('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
