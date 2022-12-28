<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Aboutustranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('aboutustranslations', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('about_us_id');
            $table->string('locale');
            $table->text('name');
            $table->unique(['about_us_id', 'locale']);
            $table->foreign('about_us_id')->references('id')->on('aboutus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
