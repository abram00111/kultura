<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('fio');
            $table->string('short_fio');
            $table->date('dob')->nullable();
            $table->string('login')->unique()->nullable();
            $table->string('password');
            $table->string('avatar')->default('user.jpg');
            $table->unsignedBigInteger('status_id')->default(1); //1 = ученик
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->integer('class')->nullable();
            $table->string('class_bukva')->nullable();
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
