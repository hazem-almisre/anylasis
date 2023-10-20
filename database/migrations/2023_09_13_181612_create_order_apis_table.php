<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_apis', function (Blueprint $table) {
            $table->bigIncrements('orderId');
            $table->unsignedBigInteger('nurseId')->nullable();
            $table->unsignedBigInteger('contactId');
            $table->unsignedBigInteger('labId');
            $table->unsignedBigInteger('userId');
            $table->string('totalPrice');
            $table->text('instructios');
            $table->enum('status',['finish','prosessing']);
            $table->string('date'); //dateStart
            $table->boolean('isFrequency')->default(false);
            $table->foreign('nurseId')->references('nurseId')->on('nurses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('labId')->references('labId')->on('labs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('contactId')->references('contactId')->on('contacts')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('order_apis');
    }
}
