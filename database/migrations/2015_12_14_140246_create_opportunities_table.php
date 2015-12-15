<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('workplace_id')->index();
            $table->unsignedTinyInteger('max_visitors');
            $table->text('description')->nullable();
            $table->dateTime('start')->index();
            $table->dateTime('end');
            $table->dateTime('registration_end')->index();
            $table->text('address');
            $table->string('contact_name', 100);
            $table->string('contact_phone', 20);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('opportunities');
    }
}
