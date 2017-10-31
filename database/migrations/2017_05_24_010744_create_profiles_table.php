<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname')->unique();
            $table->string('groups');
            $table->integer('points')->default(0);
            $table->string('emoji')->nullable();
            $table->integer('streak')->default(0);
            $table->dateTime('checked_in')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('profiles', function ($table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropForeign(['post_id']);
        Schema::dropIfExists('profiles');
    }
}
