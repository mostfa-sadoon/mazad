<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivecyCondetionTransltionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privacy_transltions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('privecycondetion_id');
            $table->string('locale');
            $table->text('desc');
            $table->unique(['privecycondetion_id', 'locale']);
            $table->foreign('privecycondetion_id')->references('id')->on('privacycondetions')->onDelete('cascade');
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
        Schema::dropIfExists('privecy_condetion_transltions');
    }
}
