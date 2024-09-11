<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTravelodgesTable extends Migration
{
    public function up()
    {
        Schema::table('travelodges', function (Blueprint $table) {

            $table->dropColumn('location');

            $table->unsignedBigInteger('assignee_id')->nullable();


            $table->foreign('assignee_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('travelodges', function (Blueprint $table) {

            $table->dropForeign(['assignee_id']);
            $table->dropColumn('assignee_id');
            $table->string('location')->nullable();
        });
    }
}
