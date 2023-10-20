<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labs', function (Blueprint $table) {
            $table->bigIncrements('labId');
            $table->string('name');
            $table->string('phone');
            $table->string('ownerName');
            $table->string('phoneEnter')->unique();
            $table->string('password');
            $table->string('region');
            $table->string('address');
            $table->text('photo');
            // $table->text('description');
            // $table->text('notification_token');
            $table->unsignedBigInteger('labLocationId');
            $table->foreign('labLocationId')->references('labLocationId')->on('lab_locations')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('isActive')->default(0);
            $table->boolean('distinct')->default(0);
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
        Schema::dropIfExists('labs');
    }
}
