<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuetionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quetion_translations', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('quetion_id');
            $table->string('locale');
            $table->string('quetion');
            $table->text('answer');
            $table->unique(['quetion_id', 'locale']);
            $table->foreign('quetion_id')->references('id')->on('quetions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quetion_translations');
    }
}
