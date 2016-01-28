<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccupationWorkplaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occupation_workplace', function (Blueprint $table) {
            $table->unsignedInteger('occupation_id');
            $table->unsignedInteger('workplace_id');

            $table->unique(['occupation_id', 'workplace_id']);
            $table->index(['workplace_id', 'occupation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('occupation_workplace');
    }
}
