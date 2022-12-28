<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecognitionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recognition_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recognition_id')->unsigned();
            $table->string('locale');
            $table->string('name');

            $table->unique(['recognition_id', 'locale']);
            $table->foreign('recognition_id')->references('id')->on('recognitions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recognition_translations');
    }
}
