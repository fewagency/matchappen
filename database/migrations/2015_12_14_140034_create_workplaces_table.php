<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workplaces', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_published')->nullable()->default(null); //null requires attention by admin for publishing
            $table->string('name');
            $table->string('slug')->index();
            $table->unsignedSmallInteger('employees')->index();
            $table->text('description')->nullable();
            $table->string('homepage')->nullable();
            $table->string('contact_name', 100)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
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
        Schema::drop('workplaces');
    }
}
