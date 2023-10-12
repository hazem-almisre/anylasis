<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurses', function (Blueprint $table) {
            $table->bigIncrements('nurseId');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('address');
            $table->text('photo')->nullable();
            $table->integer('ratio');
            $table->string('password');
            $table->string('socId')->default('0');
            $table->boolean('isActive')->default(0);
            $table->text('notification_token')->nullable();
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
        Schema::dropIfExists('nurses');
    }
}
