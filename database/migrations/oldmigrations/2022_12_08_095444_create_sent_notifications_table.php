<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_notifications', function (Blueprint $table) {
            $table->increments('id');
            //users
            $table->integer('sender_id')->unsigned()->nullable();
            $table->string('sender_model')->nullable();
            $table->integer('receiver_id')->unsigned()->nullable();
            $table->string('receiver_model')->nullable();

            $table->string('type')->nullable();
            $table->integer('type_id')->unsigned()->nullable();

            $table->integer('message_id')->nullable();
            $table->text('message')->nullable();

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
        Schema::dropIfExists('sent_notifications');
    }
}
