<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_areas', function (Blueprint $table) {
            $table->bigIncrements('doctorAreasId');
            $table->unsignedBigInteger('labLocationId');
            $table->unsignedBigInteger('nurseId');
            $table->foreign('labLocationId')->references('labLocationId')->on('lab_locations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nurseId')->references('nurseId')->on('nurses')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('doctor_areas');
    }
}
