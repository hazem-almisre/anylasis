<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analysis_offers', function (Blueprint $table) {
            $table->bigIncrements('AnalysisOfferId');
            $table->unsignedBigInteger('analysisId');
            $table->foreign('analysisId')->references('analysisId')->on('analyses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('offerId');
            $table->foreign('offerId')->references('offerId')->on('offers')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('analysis_offers');
    }
}
