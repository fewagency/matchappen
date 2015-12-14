<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessTokenLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_token_log', function (Blueprint $table) {
            //$table->engine = 'MyISAM'; // This could make writes faster, but may not be as stable

            $table->unsignedBigInteger('access_token_id')->nullable()->index();
            $table->string('email')->index();
            $table->string('token');
            $table->string('ip', 39)->index();
            $table->timestamp('created_at')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('access_token_log');
    }
}
