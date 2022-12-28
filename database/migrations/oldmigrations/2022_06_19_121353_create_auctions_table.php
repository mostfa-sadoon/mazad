<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('client_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->string('name');
            // $table->string('short_description');
            $table->text('description');

            $table->decimal('min_price');
            $table->decimal('max_price');
            $table->decimal('end_price')->nullable();

            $table->string('cover');
            $table->string('video')->nullable();


            $table->date('end_date');
            $table->time('end_time');

            $table->tinyInteger('status')->comment('2 for closed, 1 for sold')->nullable();
            $table->tinyInteger('is_active')->default(1);
            
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            $table->timestamps();

            
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctions');
    }
}
