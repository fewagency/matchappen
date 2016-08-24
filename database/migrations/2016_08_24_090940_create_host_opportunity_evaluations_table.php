<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostOpportunityEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('host_opportunity_evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('rating');
            $table->text('comment');
            $table->unsignedInteger('opportunity_id');
            $table->unsignedInteger('user_id');
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
        Schema::drop('host_opportunity_evaluations');
    }
}
