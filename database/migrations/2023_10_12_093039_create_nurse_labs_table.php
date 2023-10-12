<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNurseLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurse_labs', function (Blueprint $table) {
            $table->id('nurseLabId');
            $table->unsignedBigInteger('nurseId');
            $table->unsignedBigInteger('labId');
            $table->foreign('nurseId')->references('nurseId')->on('nurses')->onUpdate('cascade');
            $table->foreign('labId')->references('labId')->on('labs')->onDelete('cascade');
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
        Schema::dropIfExists('nurse_labs');
    }
}
