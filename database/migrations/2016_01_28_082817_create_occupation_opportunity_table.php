<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccupationOpportunityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occupation_opportunity', function (Blueprint $table) {
            $table->unsignedInteger('occupation_id');
            $table->unsignedInteger('opportunity_id');

            $table->unique(['occupation_id', 'opportunity_id']);
            $table->index(['opportunity_id', 'occupation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('occupation_opportunity');
    }
}
