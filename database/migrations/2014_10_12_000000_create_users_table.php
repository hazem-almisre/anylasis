<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->text('photo')->nullable();
            $table->string('address')->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            $table->string('gendor')->nullable();
            $table->string('socId')->default('1');
            $table->date('birthDay')->nullable();
            $table->integer('role')->default(0);
            $table->text('notification_token');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
