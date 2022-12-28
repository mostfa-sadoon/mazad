<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeSectionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homesectiontranslations', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('home_section_id');
            $table->string('locale');
            $table->string('name');
            $table->text('desc');
            $table->unique(['home_section_id', 'locale']);
            $table->foreign('home_section_id')->references('id')->on('home_sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_section_translations');
    }
}
