<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("users", function(Blueprint $table){
            $table->increments("id");
            $table->string("username")->unique();
            $table->string("password");
            $table->string("email")->unique();
            $table->string("name")->nullable();
            $table->string("lastname")->nullable();
            $table->string("phone")->nullable();
            $table->date("birthday")->nullable();
            $table->integer('picture_id')->unsigned()->nullable();
            $table->foreign('picture_id')->references('id')->on('pictures');
            $table->string("remember_token")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
