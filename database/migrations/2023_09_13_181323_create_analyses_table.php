<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analyses', function (Blueprint $table) {
            $table->bigIncrements('analysisId');
            $table->string('lable')->unique();
            $table->integer('price');
            $table->text('description');
            $table->string('firstPrice');
            $table->string('secondPrice')->nullable();
            $table->unsignedBigInteger('labId');
            $table->foreign('labId')->references('labId')->on('labs')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('analyses');
    }
}
