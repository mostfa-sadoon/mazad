<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubAttributeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_attribute_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_attribute_id')->unsigned();
            $table->string('locale');
            $table->string('name');

            $table->unique(['sub_attribute_id', 'locale']);
            $table->foreign('sub_attribute_id')->references('id')->on('sub_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_attribute_translations');
    }
}
