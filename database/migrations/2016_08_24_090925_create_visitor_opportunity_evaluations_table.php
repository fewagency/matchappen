<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorOpportunityEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_opportunity_evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('rating');
            $table->text('comment');
            $table->unsignedInteger('booking_id');
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
        Schema::drop('visitor_opportunity_evaluations');
    }
}
