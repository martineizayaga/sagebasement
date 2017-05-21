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
            $table->increments('user_id');
            $table->string('nickname');
            $table->enum('group', ['gleeclub', 'chorus', 'chorale', 'fan']);
            $table->integer('points');
            $table->integer('streak');
            $table->dateTime('checked_in');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
