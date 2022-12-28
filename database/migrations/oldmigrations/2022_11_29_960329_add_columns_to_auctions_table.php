<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->integer('recognition_id')->unsigned()->nullable()->after('category_id');
            $table->date('recognition_start_date')->nullable()->after('recognition_id');
            $table->date('recognition_end_date')->nullable()->after('recognition_start_date');


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
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn('recognition_id');
            $table->dropColumn('recognition_start_date');
            $table->dropColumn('recognition_end_date');
        });
    }
}
